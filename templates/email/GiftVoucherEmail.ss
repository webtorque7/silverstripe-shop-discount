<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>$Subject</title>

	<style type="text/css">
		/* Reset */
		#outlook a {padding:0;}
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;}
		.image_fix {display:block;}
		p {margin: 1.1em 0;}
		h1, h2, h3, h4, h5, h6 {color: #4c4D4f !important;}
		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: #009ac8 !important;}
		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: #db0962 !important;}
		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {color: #933c91 !important;}
		table td {border-collapse: collapse;}
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
		a {color: #0095c8; text-decoration: none;}
		a:hover {color: #5f259f;}

		a.footerLinks {color: #c5c7c9;}
		a.footerLinks:hover {color: #959595;}
		/* Mobile targetting */
		@media only screen and (max-device-width: 480px) {
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: #009ac8;
				pointer-events: none;
				cursor: default;
			}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: #009ac8 !important;
				pointer-events: auto;
				cursor: default;
			}
		}
		/* Tablet Targeting */
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: #009ac8; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: #009ac8 !important;
				pointer-events: auto;
				cursor: default;
			}
		}
	</style>

	<!--[if gte mso 9]>
	<style>
		/* Target Outlook 2007 and 2010 */
	</style>
	<![endif]-->
</head>
<body style="font-size: 13px; line-height: 19px; color: #1e1e1e; font-family: Arial, sans-serif; background: #bababa;">
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" width="100%" style="background: #bababa; line-height: normal !important;">
	<tr height="42"><td>&nbsp;</td></tr>
	<tr>
		<td width="40">&nbsp;</td>
		<td valign="top">

			<table cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #fff;">
				<tr style="background: white;">
					<td width="768" valign="top">
						<table cellpadding="0" cellspacing="0" border="0" align="center" style="background: #4c4d4f;" >
							<tr>
                                <td width="768" height="119" style="background: #1e1e1e; text-align: center;">
									<a href="" target="_blank">
										<img class="image_fix" src="/mysite/images/gibbston-valley-email-logo.png" alt="Gibbston Valley email banner image" title="Gibbston Valley" style="margin: 0 auto;"/>
									</a>
								</td>
							</tr>
						</table>

						<table width="100%" height="42" style="line-height: 20px; background: #f9f6f2;">
							<tr height="30" style="text-align: center; text-transform: uppercase; font-weight: 300; font-size: 15px;"><td>Good Wine &middot; Good Food &middot; Good Living</td></tr>
						</table>

						<% with $Coupon %>
							<table width="100%" style="background: white; text-align: center; color: #ae8346; margin: 20px 0 16px 0;">
								<tr style="font-size: 24px; font-weight: normal;"><td>$CurrentMember.FirstName has sent you a<br>$Title</td></tr>
								<tr><td style="padding-top: 8px;">- $Top.TimeStamp -</td></tr>
							</table>

							<table width="550" style="background: #ffffff; margin: 0 auto; text-align: center;">
								<tr>
									<td style="border-top: 1px dotted #ac824c; border-bottom: 1px dotted #ac824c; padding: 18px 0;">
										<table width="100%">
											<% if $GiftVoucher.GiftNotes %>
												<tr>
													<td style="line-height: 19px;">$GiftVoucher.GiftNotes</td>
												</tr>
											<% end_if %>
											<tr>
												<td style="font-size: 110px; color: #ae8346; padding-top: 5px;">$Amount.Nice</td>
											</tr>
											<tr>
												<td style="padding: 8px 0 18px 0;">Your gift voucher code: $Code</td>
											</tr>
											<tr>
												<td><a href="$Top.ShopHome.Link" style="text-decoration: none; font-weight: bold; font-size: 12px; background: url(/mysite/images/arrow_right.png) no-repeat right center #1e1e1e; text-transform: uppercase; color: #fff; padding: 6px 26px 6px 8px; display: inline-block;">Shop now</a></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="border-bottom: 1px dotted #ac824c; padding: 10px 0 18px 0;">
										<table width="100%">
											<tr style="font-size: 24px; color: #ae8346;">
												<td>What can I buy?</td>
											</tr>
											<tr>
												<td style="padding: 18px 0; line-height: 19px;" ><a href="$Top.ShopHome.Link" style="display: inline; text-decoration: underline; color: inherit;">Browse our website</a> or visit us at the winery to redeem your voucher.
													You can use it to buy Wine, food, homewares and gifts. Or treat yourself to a meal, or a wine experience.</td>
											</tr>
											<tr style="font-size: 10px; line-height: 14px;">
												<td>
													$GiftVoucher.Product.UseConditions
												</td>
											</tr>
										</table>
									</td>
								</tr>

								<tr style="text-align: center;">
									<td>
                                        <table width="100%" style="border-spacing: 0; margin: 10px 0 22px 0; text-align: center; text-transform: uppercase; font-size: 16px; color: #ae8346;">
                                            <tr>
                                                <td width="20%">&nbsp;</td>
                                                <td width="20%"><img src="/mysite/images/basket.png" alt="Shop"/></td>
                                                <td width="20%"><img src="/mysite/images/grape.png" alt="Visit"/></td>
                                                <td width="20%"><img src="/mysite/images/bottle.png" alt="Join"/></td>
                                                <td width="20%">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="border-top: 2px solid #ae8346; border-bottom: 2px solid #ae8346; padding: 7px 0;">&nbsp;</td>
                                                <td width="20%" style="border-top: 2px solid #ae8346; border-bottom: 2px solid #ae8346; padding: 7px 0;">Shop</td>
                                                <td width="20%" style="border-top: 2px solid #ae8346; border-bottom: 2px solid #ae8346; padding: 7px 0;">Visit</td>
                                                <td width="20%" style="border-top: 2px solid #ae8346; border-bottom: 2px solid #ae8346; padding: 7px 0;">Join</td>
                                                <td width="20%" style="border-top: 2px solid #ae8346; border-bottom: 2px solid #ae8346; padding: 7px 0;">&nbsp;</td>
                                            </tr>
                                        </table>
									</td>
								</tr>
							</table>
					    	<% end_with %>
					</td>
				</tr>
				<tr>
					<td>
                        <table width="100%" style="background: #f9f6f2; text-align: center;">
                            <tr height="47" style="font-size: 11px;">
                                <td style="padding-top: 20px;">
									<span><span style="margin-right: 10px; background-image: url(/mysite/images/phone.png); background-repeat: no-repeat; background-position: left center; padding: 7px 0 7px 32px;">
                                        <a href="tel:%2B64%203%20442%206910" value="+6434426910" target="_blank" style="font-size: 11px; text-decoration: none; color: #1e1e1e;">+64 3 442 6910</a>
									</span></span>
									<span><span style="margin-right: 10px; background-image: url(/mysite/images/email.png); background-repeat: no-repeat; background-position: left center; padding: 7px 0 7px 32px;">
                                        <a href="mailto:info@gibbstonvalleynz.com" target="_blank" style="font-size: 11px; text-decoration: none; color: #1e1e1e;">info@gibbstonvalleynz.com</a>
									</span></span>
                                </td>
                            </tr>
                            <tr height="47" style="font-size: 9px;">
                                <td style="padding-bottom: 10px;">Gibbston Valley Winery | 1820 State Highway 6, Queenstown, New Zealand 9371</td>
                            </tr>
                        </table>
					</td>
				</tr>
			</table>

			<!-- <a href="http://htmlemailboilerplate.com" target ="_blank" title="Styling Links" style="color: #009ac8; text-decoration: none;">Coloring Links appropriately</a>

			    <img class="image_fix" src="full path to image" alt="Your alt text" title="Your title text" width="x" height="x" />

			     -->

		</td>
		<td width="40">&nbsp;</td>
	</tr>
	<tr height="18"><td>&nbsp;</td></tr>
</table>
<!-- End of wrapper table -->
</body>
</html>
