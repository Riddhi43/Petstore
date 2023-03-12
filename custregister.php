<?php
include "./inc/cu.common.php";

$txtname = isset($_POST["txtname"]) ? $_POST["txtname"] : "";
$txtemail = isset($_POST["txtemail"]) ? $_POST["txtemail"] : "";
$txtphone = isset($_POST["txtphone"]) ? $_POST["txtphone"] : "";
$txtaddress = isset($_POST["txtaddress"]) ? $_POST["txtaddress"] : "";
$txtusername = isset($_POST["txtusername"]) ? $_POST["txtusername"] : "";
$txtpassword = isset($_POST["txtpassword"]) ? $_POST["txtpassword"] : "";

if(!empty($txtname) && !empty($txtemail) && !empty($txtusername) && !empty($txtpassword)) {
	$password = md5($txtpassword);

	$id = NextId("id", "customer");
	$q = "INSERT INTO customer(id, custName, userName, password, custNumber, custEmail) VALUES ($id, '$txtname', '$txtusername', '$password', '$txtphone', '$txtemail')";
	$r = sql_query($q);
	if(sql_affected_rows($r)) {
		// insert address
		$q1 = "INSERT INTO customer_address(fkCustomerId, address, title) VALUES ($id, '$txtaddress', 'Default')";
		$r1 = sql_query($q1);
		ForceOutCu(1, "login.php");	// registered successfully!; send to login page
	}
	else {
		ForceOutCu(2, "register.php");	// registered fail!; send to registerpage
	}
}
else {
	// invalid details
	ForceOutCu(6, "register.php");
}
?>