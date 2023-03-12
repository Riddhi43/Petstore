<?php 
require_once('./inc/cu.common.php');

if($_SERVER['REQUEST_METHOD']=="POST"){

	if(isset($_POST["user_username"]) && isset($_POST["user_password"])){
		$username = $_POST['user_username'];
		$password = $_POST['user_password'];

		if($password=='')
			ForceOutCu(2, "login.php");
		elseif($username=='')
			ForceOutCu(3, "login.php");
		else{
			$q = "SELECT id, custName, username, password FROM customer WHERE username='$username' ";
			$r = sql_query($q);

			if(sql_num_rows($r)){
				list($u_id, $u_name, $u_username, $u_password) = sql_fetch_row($r);

				if($u_password == md5($password)){
					session_destroy();
					session_start();

					$_SESSION[CU_SESSION_ID] = new userdat;
					$_SESSION[CU_SESSION_ID]->log_stat = "A";
					$_SESSION[CU_SESSION_ID]->cust_id = $u_id;
					$_SESSION[CU_SESSION_ID]->cust_name = $u_name;
					$_SESSION[CU_SESSION_ID]->sess_id = session_id();
					$_SESSION[CU_SESSION_ID]->log_time = NOW;
					$_SESSION[CU_SESSION_ID]->cust_wishlist = getCount("customer_wishlist", "COUNT(*)", "and fkCustomerId = ".$u_id);
					$_SESSION[CU_SESSION_ID]->cust_cart = getCount("customer_cart", "COUNT(*)", "and fkCustomerId = ".$u_id);
					$_SESSION[CU_SESSION_ID]->cust_cart_total = GetXFromYID("SELECT SUM(p.productPrice) FROM `customer_cart` c left join product p on c.fkProductId=p.id WHERE fkCustomerId = $u_id");

					header("location:product.php");
					exit;
				}
				else{
					// incorrect password
					ForceOutCu(4, "login.php");
				}
				
			}
			else{
				ForceOutCu(5, "login.php");
			}
		}
	}
	else{
		ForceOutCu(6);
	}
}
else{
	session_destroy();
	ForceOutCu(7);
	exit;
}
?>