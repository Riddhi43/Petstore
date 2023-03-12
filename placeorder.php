<?php
include "inc/cu.common.php";

if(!$cust_logged || !isset($sess_cust_id) || !is_numeric($sess_cust_id)) {
	ForceOutCu(3);
}

$redirect = false;
$rdaddress = isset($_POST['rdaddress']) ? $_POST['rdaddress'] : "";
$shipping_address = GetXFromYID("SELECT address FROM customer_address WHERE id = $rdaddress");

// lock tables
/*sql_query("LOCK TABLE orders READ");
sql_query("LOCK TABLE orders WRITE");
sql_query("LOCK TABLE order_item WRITE");
sql_query("LOCK TABLE order_status WRITE");
sql_query("LOCK TABLE customer WRITE");
sql_query("LOCK TABLE customer_cart WRITE");
sql_query("LOCK TABLE customer_address WRITE");*/

$ordid = NextId("id", "orders");
$q = "INSERT INTO orders(id, fkCustomerId, orderType, orderDate, shippingAddress, paymentMethod, status) VALUES ($ordid, $sess_cust_id, 'ORD', '".TODAY."', '$shipping_address', 'COD', 'A')";
$r = sql_query($q);

if(sql_affected_rows($r)) {
	$q1 = "INSERT INTO order_item(fkOrderId, fkProductId, unitPrice, itemQuantity, totalPrice) SELECT $ordid, c.fkProductId, SUM(p.productPrice), SUM(c.qty), (SUM(p.productPrice) * SUM(c.qty)) FROM customer_cart c left join product p on c.fkProductId = p.id WHERE fkCustomerId = $sess_cust_id GROUP BY c.fkProductId";
	$r1 = sql_query($q1);

	if(sql_affected_rows($r1)) {
		$q2 = "UPDATE orders SET totalAmount = (SELECT SUM(totalPrice) FROM order_item WHERE fkOrderId = $ordid ) WHERE id = $ordid ";
		$r2 = sql_query($q2);

		$redirect = true;
	}
}
// unlock tables
sql_query("UNLOCK TABLES");

if($redirect) {
	// clear cart
	sql_query("DELETE FROM customer_cart WHERE fkCustomerId = $sess_cust_id");

	$_SESSION[CU_SESSION_ID]->cust_cart = getCount("customer_cart", "COUNT(*)", "and fkCustomerId = ".$sess_cust_id);
	$_SESSION[CU_SESSION_ID]->cust_cart_total = GetXFromYID("SELECT SUM(p.productPrice) FROM customer_cart c left join product p on c.fkProductId=p.id WHERE fkCustomerId = $sess_cust_id"); 

	header("location: order-success.php");
	exit;
}
else {
	ForceOutCu(3);
	exit;
}
?>