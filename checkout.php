<?php
include "./inc/cu.common.php";

if(!$cust_logged || !is_numeric($sess_cust_id)) {
    ForceOutCu(3);
    exit;
}

$cust_email = GetXFromYID("SELECT custEmail from customer WHERE id = $sess_cust_id");

$q = "SELECT p.id, p.productName, p.productPrice, p.productImg, c.fkCustomerId, c.qty FROM customer_cart c left join product p on c.fkProductId = p.id WHERE c.fkCustomerId = $sess_cust_id";
$r = sql_query($q);
$cart_items = sql_get_data($r);
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
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <?php if(!empty($cart_items)) { ?>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="placeorder.php" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout-cust">
                                <table class="cust-table">
                                    <tr>
                                        <td><b>Customer Name: </b><?php echo $sess_cust_name; ?></td>
                                        <td><b>Email: </b><?php echo $cust_email; ?></td>
                                    </tr>
                                </table>
                                <div class="">
                                    <br/>
                                    <h5><b>Choose Address</b></h5>
                                    <?php
                                    $addresses = getDataFromTable("customer_address", "id, address, title", "and fkCustomerId = $sess_cust_id");

                                    if(!empty($addresses) && count($addresses)) {
                                        foreach($addresses as $_ADR) {
                                            $selected = "checked";
                                            $ctrl_id = "rd_".$_ADR->id;
                                            ?>
                                            <div class="add-radio">
                                                <input type="radio" <?php echo $selected; ?> id="<?php echo $ctrl_id; ?>" name="rdaddress" value="<?php echo $_ADR->id; ?>" />
                                                <label for="<?php echo $ctrl_id; ?>">
                                                    <b><?php echo $_ADR->title; ?></b><br/>
                                                    <?php echo $_ADR->address; ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                <?php
                                $TOT_AMT = 0;
                                if(!empty($cart_items) && count($cart_items)) {
                                    foreach($cart_items as $obj_w) {
                                        $p_img = (!empty($obj_w->productImg) && file_exists(PROD_IMG_UPLOAD.$obj_w->productImg) ) ? PROD_IMG_PATH.$obj_w->productImg : "img/cart/cart-1.jpg";
                                        $p_url = "product-detail.php?id=".$obj_w->id;

                                        $tot_amt = $obj_w->qty * $obj_w->productPrice;
                                        $TOT_AMT += $tot_amt;
                                        ?>
                                        <li><?php echo $obj_w->productName; ?> <span><?php echo Rs.$tot_amt; ?></span></li>
                                        <?php
                                    }
                                }
                                ?>
                                </ul>
                                <hr />
                                <div class="checkout__order__total">Total <span><?php echo Rs.$TOT_AMT; ?></span></div>
                                <p>This is a Cash on Delivery(COD) Order. <br/> Estimated date of arrival
                                    <b><?php echo date("d-m-Y",strtotime("+4days"))." - ".date("d-m-Y",strtotime("+7days")); ?></b>.
                                </p>
                                <?php if($TOT_AMT > 0) { ?>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </section>
    <!-- Checkout Section End -->

    <?php include "_footer.php"; ?>
</body>
</html>