<?php
include "./inc/cu.common.php";
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
                        <h2>Shopping Bag</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Shopping Bag</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <?php if($cust_logged) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = "SELECT p.id, c.id as 'cart_id', p.productName, p.productPrice, p.productImg, c.fkCustomerId, c.qty FROM customer_cart c left join product p on c.fkProductId = p.id WHERE c.fkCustomerId = $sess_cust_id";
                                $r = sql_query($q);
                                $cart_items = sql_get_data($r);
                                $TOT_AMT = 0;
                                if(!empty($cart_items) && count($cart_items)) {
                                    foreach($cart_items as $obj_w) {
                                        $p_img = (!empty($obj_w->productImg) && file_exists(PROD_IMG_UPLOAD.$obj_w->productImg) ) ? PROD_IMG_PATH.$obj_w->productImg : "img/cart/cart-1.jpg";
                                        $p_url = "product-detail.php?id=".$obj_w->id;

                                        $tot_amt = $obj_w->qty * $obj_w->productPrice;
                                        $TOT_AMT += $tot_amt;
                                        ?>
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="<?php echo $p_img; ?>" alt="<?php echo $obj_w->productName; ?>">
                                                <h5><?php echo $obj_w->productName; ?></h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                <?php echo Rs.$obj_w->productPrice; ?>
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" value="<?php echo $obj_w->qty; ?>" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                <?php echo $tot_amt; ?>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <a href="javascript:;" onclick="removeFromCart(this,'<?php echo $obj_w->cart_id; ?>', '<?php echo $obj_w->fkCustomerId; ?>');"  class="icon_close"></span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    echo "<tr><td colspan='5'>No items added to cart.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="product.php" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    </div>
                </div>
                <?php if($TOT_AMT > 0) { ?>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Total <span><?php echo Rs.$TOT_AMT; ?></span></li>
                        </ul>
                        <a href="javascript:;" onclick="validateCart('<?php echo $sess_cust_id; ?>');" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php }
            else {
                echo '<p>You are not logged in. Please <a href="login.php">login</a> to view your shopping bag.</p>';
            } 
            ?>
        </div>
    </section>
    <!-- Shoping Cart Section End -->


    <?php include "_footer.php"; ?>
    <script type="text/javascript">
        function validateCart(cust_id) {
            if(cust_id != "") {
                $.ajax({
                    url: ajax_url,
                    type: "post",
                    data: {mode:"CHECKOUT_CART", cid:cust_id},
                    async: false,
                    success: function(result) {
                        res = JSON.parse(result);
                        ret = (res.code == '1') ? true : false;
                        if(res.code == '0') {
                            showMessage(res.message);
                        }
                    },
                    error: function(errores) {
                        console.log(errores.responseText);
                    }
                });

                if(ret) {
                    window.location.href = "checkout.php";
                }
            }
        }

        function removeFromCart(elm, id, cust_id) {
            if(id != "") {
                $.ajax({
                    url: ajax_url,
                    type: "post",
                    data: {mode:"REMOVE_FROM_CART", id:id, cid:cust_id},
                    async: false,
                    success: function(result) {
                        res = JSON.parse(result);
                        if(res.code) {
                            showMessage(res.message);
                            $(elm).closest("tr").remove();
                        }
                    },
                    error: function(errores) {
                        console.log(errores.responseText);
                    }
                });

                if(ret) {
                    window.location.href = "checkout.php";
                }
            }
        }
    </script>
</body>
</html>