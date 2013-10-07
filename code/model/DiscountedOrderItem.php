<?php

class DiscountedOrderItem extends DataExtension {
	
	private static $db = array(
		'Discount' => 'Currency'
	);
	
}