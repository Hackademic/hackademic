
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Billing Information - DeskTest</title>
<link rel="stylesheet" type="text/css" href="common.css">

<link rel="stylesheet" type="text/css" href="default.css">

<link rel="stylesheet" type="text/css" href="orderInfo.css">
<style type="text/css"></style>
<br/>

 <div>
  <body background="newback.jpg">
<body>
<div/>
<br/>
</head>
<hr>
<div id="main"><form method="post" id="billingform" name="billing" action="payform.php">
<input type="hidden" id="r_country_code" name="refresh_country_code" value="0">
<input name="form_charset" type="hidden" value="UTF-8">
<input type="hidden" name="cmd" value="_flow"><input type="hidden" name="id" value="">
<input type="hidden" name="note" value=""><input type="hidden" name="close_external_flow" value="false">
<input border="0" type="image" src="" id="dfltButton" name="continue.x" value="Continue" width="1" height="1">
<div id="shopping-cart"><div id="purchase-detail">

<input type="hidden" id="editable-order" name="editable-order" value="1"><input type="hidden" id="item-quantity" name="item-quantity" value="1"><div id="cover"><table id="cart">
<thead><tr>
<th class="item-name"><font size = 3><b>Item<b/></th>
<th><font size = 3><b>Unit Price<b/></th>
<th><abbr title="Quantity"><font size = 3><b>Qty<b/></abbr></th>
<th class="item-total" width="1%"><font size = 3><b>Total<b/></th>
<th></th>
<br/>
</tr></thead>
<tr>
<td class="item-name">Funrally Axis Cube Black<p class="item-option">Item Number 
#1127856</p>
</td>
<td><?php echo $_POST["amount"]; ?></td>
<td><input type="text" id="quantity" size="4" maxlength="4" name="quantity" value="1" ></td>
<td class="item-total"><?php echo $_POST["amount"]; ?></td>
<td></td>
</tr>
<tfoot>
<tr class="subtotal">
<td id="notes" valign="top"></td>
<td colspan="3"></td>
<td></td>
</tr>

<tr>
<td colspan="3">Subtotal:</td>
<td class="totals-value"><?php echo $_POST["amount"] . " USD"; ?></td>
<td></td>
</tr>
<tr id="exp_total">
<td class="totals-currency"><strong></strong></td>
</tr>

<tr><td class="totals-action" colspan="4"><div class="buttonrow">
</tfoot>
</table></div>
<div id="purchase-summary">
<div id="purchase-many"><p>Funrally Axis Cube Black</p></div>
<p class="summary-total"><span>Total:</span><span class="price-currency">USD</span><div id="totals"><table align="right" border="0" cellpadding="0" cellspacing="0" id="col_shipping-table" style=" width:100%;"></table></div>
<p></p>
<div class="clearBoth"></div>
</div>
<div class="toggle"><a id="expander" href="#" title="Click to view purchase details">Click to view purchase details</a></div>
</div></div>
<h1>
<span id="pgHdr"><font size="5">&nbsp;<img border="0" src="secured.png" width="202" height="37"></font></span></h1>
</form></div>
</div>
</body>
<p class="instructions">&nbsp;</p>
<p class="instructions">&nbsp;</p>
<p class="instructions">&nbsp;</p>
<p class="instructions"></p>
<p class="instructions">&nbsp;</p>
<p class="instructions">&nbsp;</p>
<form method="POST" action="continues.php">
    <p>
    <input type="hidden" name="amount" value="<?php echo $_POST["amount"]; ?> "/>
    <input type="submit" value=" Enter Payment Details " name="button"></p>
</form>
<p>&nbsp;</p>

</html>




