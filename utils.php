<?php
include "inc/cu.common.php";


$q5 = "TRUNCATE TABLE product_stock";
// echo $q5.";<br/>";

// Update product images in db
$q = "SELECT * FROM product";
$r = sql_query($q);
while ($row = sql_fetch_assoc($r)) {
	$pname = GetUrlName($row['productName']);
	$q1 = "UPDATE product set productImg='$pname.jpg' WHERE id = '".$row['id']."'; ";
	// echo $q1.';<br/>';

	$q2 = "UPDATE product set productPrice='".rand(20,100)."' WHERE id = '".$row['id']."'; ";
	// echo $q2.'<br/>';

	$q3 = "INSERT INTO product_stock(fkProductId, fkVendorId, qtyOnHand, newQty, totalQty, dateOfPruch, status) VALUES ('".$row['id']."', 1, 0, 10, 10, '".TODAY."', 'A')";
	// echo $q3.';<br/>';
}

$q4 = "UPDATE product set productQty = 10";
// echo $q4.';<br/>';

$c_arr = GetXArrFromYID("SELECT id, title from category",3); 
if(!empty($c_arr)) {
	foreach($c_arr as $c_id => $title) {
		$c_img = GetUrlName($title);
		$q6 = "UPDATE category set image = '".$c_img.".jpg' WHERE id = $c_id; ";
		// echo $q6.'<br/>';
	}
}

$str = "";
$count = 10000;
for($i = 1; $i<=$count; $i++) {
	$startDate = '2022-01-01';
	$endDate = '2023-02-22';

	$startTime = strtotime($startDate);
	$endTime = strtotime($endDate);

	$randomTime = rand($startTime, $endTime);
	$randomDate = date('Y-m-d', $randomTime);

	$cust_id = rand(1,40);
	$order_type = array_rand($ORDER_TYPES);
	$order_status = array_rand($ORDER_STATUSES);
	$shipping_address = GetXFromYID("SELECT address FROM customer_address WHERE fkCustomerId = $cust_id LIMIT 1");
	$num_prods = rand(1,10);

	$str .= "INSERT INTO orders(id, fkCustomerId, orderType, orderDate, totalAmount, shippingAddress, paymentMethod, status) VALUES ($i, $cust_id, '$order_type', '$randomDate', 0, '$shipping_address', 'COD', '$order_status'); <br/>";

	$t_amt = 0;
	for($j=1; $j <= $num_prods; $j++) {
		$prod_id = rand(1,80);
		$unit_price = GetXFromYID("SELECT productPrice from product WHERE id = $prod_id");
		$qty = rand(1,10);
		$totprice = $unit_price * $qty;
		$t_amt += $totprice;
		$str .= "INSERT INTO order_item(fkOrderId, fkProductId, unitPrice, itemQuantity, totalPrice) VALUES ($i,$prod_id, $unit_price, $qty, $totprice);<br/>";

	}
	$str .= "UPDATE orders SET totalAmount = $t_amt WHERE id=$i; <br/>";
	$str .= "<br/>";
}
echo $str;
?>