<?php

use Shop\Discount\Calculator;
use Shop\Discount\Adjustment;
use Shop\Discount\PriceInfo;

class CalculatorTest extends SapphireTest{
	
	protected static $fixture_file = array(
		'shop_discount/tests/fixtures/Discounts.yml',
		'shop/tests/fixtures/shop.yml',
		'shop/tests/fixtures/Zones.yml',
		'shop/tests/fixtures/Addresses.yml'
	);

	function setUp(){
		parent::setUp();
		ShopTest::setConfiguration();

		Order::config()->modifiers = array(
			"OrderDiscountModifier"
		);

		$this->socks = $this->objFromFixture("Product", "socks");
		$this->socks->publish("Stage", "Live");
		$this->tshirt = $this->objFromFixture("Product", "tshirt");
		$this->tshirt->publish("Stage", "Live");
		$this->mp3player = $this->objFromFixture("Product", "mp3player");
		$this->mp3player->publish("Stage", "Live");

		$this->cart = $this->objFromFixture("Order", "cart");
		$this->othercart = $this->objFromFixture("Order", "othercart");
		$this->megacart = $this->objFromFixture("Order", "megacart");
		$this->emptycart = $this->objFromFixture("Order", "emptycart");
		$this->modifiedcart = $this->objFromFixture("Order", "modifiedcart");
	}

	function testBasicItemDiscount() {
		//activate discounts
		$discount = $this->objFromFixture("OrderDiscount", "10percentoff");
		$discount->Active = 1;
		$discount->write();
		//check that discount works as expected
		$this->assertEquals(1, $discount->getDiscountValue(10), "10% of 10 is 1");
		//check that discount matches order
		$matching = Discount::get_matching($this->cart);
		$this->assertDOSEquals(array(
			array("Title" => "10% off")
		), $matching);
		//check valid
		$valid = $discount->valid($this->cart);
		$this->assertTrue($valid, "discount is valid");
		//check calculator
		$calculator = new Calculator($this->cart);
		$this->assertEquals(0.8, $calculator->calculate(), "10% of $8");
	}

	function testProductDiscount() {
		$discount = $this->objFromFixture("OrderDiscount", "products20percentoff");
		$discount->Active = 1;
		$discount->ExactProducts = 1;
		//selected products
		$discount->Products()->add($this->socks);
		$discount->Products()->add($this->tshirt);
		$discount->write();
		//should work for megacart
		//20 * socks($8) = 160 ...20% off each = 32
		//10 * tshirt($25) = 250 ..20% off each  = 50
		//2 * mp3player($200) = 400 ..nothing off = 0
		//total discount: 82
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(82, $calculator->calculate(), "20% off selected products");
		//no discount for cart
		$calculator = new Calculator($this->cart);
		$this->assertEquals(0, $calculator->calculate(), "20% off selected products");		
		//no discount for modifiedcart
		$calculator = new Calculator($this->modifiedcart);
		$this->assertEquals(0, $calculator->calculate(), "20% off selected products");
		
		//partial match
		$discount->ExactProducts = 0;
		$discount->write();
		//total discount: 82
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(82, $calculator->calculate(), "20% off selected products");
		//discount for cart: 32 (just socks)
		$calculator = new Calculator($this->cart);
		$this->assertEquals(1.6, $calculator->calculate(), "20% off selected products");			
		//no discount for modified cart
		$calculator = new Calculator($this->modifiedcart);
		$this->assertEquals(0, $calculator->calculate(), "20% off selected products");

		//get individual item discounts
		$discount = $this->objFromFixture("Product_OrderItem", "megacart_socks")
						->Discounts()->first();
		$this->assertEquals(32, $discount->DiscountAmount);
	}

	function testMultipleDiscounts() {
		$discount = $this->objFromFixture("OrderDiscount", "10percentoff");
		$discount->Active = 1;
		$discount->write();
		$discount2 = $this->objFromFixture("OrderDiscount", "5dollarsoff");
		$discount2->Active = 1;
		$discount2->write();
		//check that discount matches order
		$matching = Discount::get_matching($this->cart);
		$this->assertDOSEquals(array(
			array("Title" => "10% off"),
			array("Title" => "$5 off")
		), $matching);

		$calculator = new Calculator($this->emptycart);
		$this->assertEquals(0, $calculator->calculate(), "nothing in cart");
		//check that best discount was chosen
		$calculator = new Calculator($this->cart);
		$this->assertEquals(5, $calculator->calculate(), "$5 off $8 is best discount");

		$calculator = new Calculator($this->othercart);
		$this->assertEquals(20, $calculator->calculate(), "10% off $400 is best discount");
		//total discount calculation
		//20 * socks($8) = 160 ...$5 off each = 100
		//10 * tshirt($25) = 250 ..$5 off each  = 50
		//2 * mp3player($200) = 400 ..10% off each = 40
		//total discount: 190
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(190, $calculator->calculate(), "complex savings example");

		$this->assertDOSEquals(array(
			array("Title" => "10% off"),
			array("Title" => "$5 off")
		), $this->megacart->Discounts());
	}

	function testCouponAndDiscount() {
		$discount = $this->objFromFixture("OrderDiscount", "10percentoff");
		$discount->Active = 1;
		$discount->write();
		$coupon = $this->objFromFixture("OrderCoupon", "10dollarsoff");
		//total discount calculation
		//20 * socks($8) = 160 ...$10 off each ($8max) = 160
		//10 * tshirt($25) = 250 ..$10 off each  = 100
		//2 * mp3player($200) = 400 ..10% off each = 40
		//total discount: 300
		$calculator = new Calculator($this->megacart, array(
			'CouponCode' => 'TENDOLLARSOFF'
		));
		$this->assertEquals(300, $calculator->calculate(), "complex savings example");
		//no coupon in context
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(81, $calculator->calculate(), "complex savings example");
	}

	function testAdjustment(){
		$adjustment1 = new Adjustment(10, null);
		$adjustment2 = new Adjustment(5, null);
		$this->assertEquals(10, $adjustment1->getValue());
		$this->assertEquals($adjustment1, Adjustment::better_of($adjustment1, $adjustment2));
	}

	function testPriceInfo(){
		$i = new PriceInfo(20);
		$this->assertEquals(20, $i->getPrice());
		$this->assertEquals(20, $i->getOriginalPrice());
		$this->assertEquals(0, $i->getCompoundedDiscount());
		$this->assertEquals(0, $i->getBestDiscount());
		$this->assertEquals(array(), $i->getAdjustments());

		$i->adjustPrice($a1 = new Adjustment(1, "a"));
		$i->adjustPrice($a2 = new Adjustment(5, "b"));
		$i->adjustPrice($a3 = new Adjustment(2, "c"));

		$this->assertEquals(12, $i->getPrice());
		$this->assertEquals(20, $i->getOriginalPrice());
		$this->assertEquals(8, $i->getCompoundedDiscount());
		$this->assertEquals(5, $i->getBestDiscount());
		$this->assertEquals(array($a1,$a2,$a3), $i->getAdjustments());
	}

	function testCartOnly() {
		//entire cart
		$discount = $this->objFromFixture("OrderDiscount", "25dollarsoffcart");
		$discount->Active = 1;
		$discount->write();
		$this->assertTrue($discount->valid($this->cart));
		$calculator = new Calculator($this->cart);
		$this->assertEquals(8, $calculator->calculate());
		$calculator = new Calculator($this->othercart);
		$this->assertEquals(25, $calculator->calculate());
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(25, $calculator->calculate());
		$discount->Active = 0;
		$discount->write();

		//products subtotal
		$discount = $this->objFromFixture("OrderDiscount", "50percentoffproductssubtotal");
		$discount->Active = 1;
		$discount->write();
		$discount->Products()->addMany(array(
			$this->socks,
			$this->tshirt
		));
		$calculator = new Calculator($this->cart);
		$this->assertEquals(4, $calculator->calculate());
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(205, $calculator->calculate());
	}

	function testMaxAmount() {
		$discount = $this->objFromFixture("OrderDiscount", "200maxdiscount");
		$discount->Active = 1;
		$discount->write();
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(200, $calculator->calculate());
		$discount->Active = 0;
		$discount->write();

		//amount item discounts
		$discount = $this->objFromFixture("OrderDiscount", "20maxdiscountamt");
		$discount->Active = 1;
		$discount->write();
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(20, $calculator->calculate());
		$discount->Active = 0;
		$discount->write();

		//percent cart discounts
		$discount = $this->objFromFixture("OrderDiscount", "40maxdiscountcart");
		$discount->Active = 1;
		$discount->write();
		$calculator = new Calculator($this->megacart);
		$this->assertEquals(40, $calculator->calculate());
	}

	function testSavingsTotal() {
		$discount = $this->objFromFixture("OrderDiscount", "limited");
		$this->assertEquals(44, $discount->getSavingsTotal());
		$discount = $this->objFromFixture("OrderCoupon", "limited");
		$this->assertEquals(22, $discount->getSavingsTotal());
	}

	function testOrderSavingsTotal() {
		$discount = $this->objFromFixture("OrderDiscount", "limited");
		$order = $this->objFromFixture("Order", "limitedcoupon");
		$this->assertEquals(44, $discount->getSavingsforOrder($order));

		$discount = $this->objFromFixture("OrderCoupon", "limited");
		$order = $this->objFromFixture("Order", "limitedcoupon");
		$this->assertEquals(22, $discount->getSavingsforOrder($order));
	}

	function testProcessDiscountedOrder() {
		$discount = $this->objFromFixture("OrderDiscount", "25dollarsoffcart");
		$discount->Active = 1;
		$discount->write();
		$cart = $this->objFromFixture("Order", "payablecart");
		$this->assertEquals(16, $cart->calculate());
		$processor = new OrderProcessor($cart);
		$processor->placeOrder();
		$this->assertEquals(16, Order::get()->byID($cart->ID)->GrandTotal());
	}
	
}