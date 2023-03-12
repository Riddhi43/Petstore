<?php
include "./inc/cu.common.php";
$ord_id = isset($_GET['id']) ? $_GET['id'] : "";
// $ord_id =  decode_value($encord_id);

if(!$cust_logged || !is_numeric($sess_cust_id)) {
    ForceOutCu(3);
    exit;
}

if(empty($ord_id) || !is_numeric($ord_id)) {
    header("location: orders.php");
    exit;
}

// function call to get details of the customer
$status = GetXFromYID("SELECT status from orders WHERE id = $ord_id");
$order_status = isset($ORDER_STATUSES[$status]) ? $ORDER_STATUSES[$status] : "Not Available";
$prod_name = GetXArrFromYID("SELECT id, productName from product", "3");
$cust_details = get_det_arr($sess_cust_id);
$order_items = get_items_arr($ord_id);
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
                        <h2>Order <?php echo '#'.encode_value($ord_id); ?></h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Orders</span>
                        </div>
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
                                       <div class="checkout-cust">
                                           <table class="cust-table">
                                                <tr>
                                                    <td colspan="2"><b>Order Status: </b><?php echo $order_status; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Order Id: </b><?php echo '#'.encode_value($ord_id); ?></td>
                                                </tr>
                                               <tr>
                                                <?php
                                                foreach($cust_details as $arr_ind => $arr_blck){
                                                ?>
                                                    <td><b>Customer Name: </b><?php echo $arr_blck->custName;?></td>
                                                    <td><b>Email: </b><?php echo $arr_blck->custEmail;?></td>
                                                <?php
                                                }
                                                ?>
                                               </tr>
                                           </table>
                                           <hr>
                                       </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="shoping__cart__table order-listing">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Product Name</th>
                                                        <th>Unit Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i=1;
                                                    foreach($order_items as $arr_ind => $arr_blck){
                                                        $prod_name_str = isset($prod_name[$arr_blck->fkProductId])? $prod_name[$arr_blck->fkProductId]: '-';
                                                        // $total_price += $arr_blck->totalPrice;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $prod_name_str; ?></td>
                                                            <td><?php echo $arr_blck->unitPrice; ?></td>
                                                            <td><?php echo $arr_blck->itemQuantity; ?></td>
                                                            <td><?php echo $arr_blck->totalPrice; ?></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
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