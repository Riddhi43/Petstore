<?php
include "./inc/cu.common.php";
if(!$cust_logged || !is_numeric($sess_cust_id)) {
    ForceOutCu(3);
    exit;
}

$q = "SELECT * FROM orders WHERE fkCustomerId=$sess_cust_id ORDER BY orderDate desc";
$r = sql_query($q);
$num_rows = sql_num_rows($r);    
?>
<!DOCTYPE html>
<html>

<head>
    <?php 
        site_seo();
        include "_header_links.php"; 
    ?>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <?php include "_header.php"; ?>

     <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>My Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

     <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <?php include "_account_menu.php"; ?>
                <div class="col-lg-9 col-md-7">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-6">
                            <div class="form-cover">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="shoping__cart__table order-listing">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Order Date</th>
                                                        <th>Order Type</th>
                                                        <th>Total Amount</th>
                                                        <th>Payment Method</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if($num_rows > 0) {
                                                        for($i=1; $o=sql_fetch_object($r); $i++) {
                                                            $type = $o->orderType;
                                                            $sr_no = $i.'.';
                                                            $id = $o->id;
                                                            $cid = $o->fkCustomerId;
                                                            $order_date = $o->orderDate;
                                                            $total_amount = $o->totalAmount;
                                                            $shipping_address = $o->shippingAddress;
                                                            $payment_method = $o->paymentMethod;
                                                            $status = $o->status;

                                                            $order_type_str = isset($ORDER_TYPES[$type]) ? $ORDER_TYPES[$type] : "-";
                                                            $view_url = "order-view.php?id=".$id;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo date("d-m-Y", strtotime($order_date)); ?></td>
                                                                <td><?php echo $order_type_str; ?></td>
                                                                <td><?php echo $total_amount; ?></td>
                                                                <td><?php echo $payment_method; ?></td>
                                                                <td>
                                                                    <a href="<?php echo $view_url; ?>" class="site-btn">VIEW</a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    else {
                                                        echo "<tr><td colspan='5'>No orders found. Continue <a href='product.php'>shopping</a> </td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <?php include "_footer.php"; ?>
</body>

</html>