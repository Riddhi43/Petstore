<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="index.php"><img src="<?php echo HEADER_LOGO; ?>" alt=""></a>
                    </div>
                    <ul>
                        <li>Address: <?php echo SHOP_ADR; ?></li>
                        <li>Phone: <?php echo SHOP_PHONE; ?></li>
                        <li>Email: <?php echo SITE_EMAIL; ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="javascript:;">Privacy Policy</a></li>
                        <li><a href="javascript:;">Our Sitemap</a></li>
                    </ul>
                    <ul>
                    <?php
                    $f_str = "";
                    if(!empty($M_ARR)) {
                        foreach($M_ARR as $_KEY => $MENU) {
                            $f_str .= '<li><a href="'.$MENU['href'].'">'.$MENU['title'].'</a>';
                            if($MENU['has_sub'] == "Y") {
                                $SUB_ARR = isset($MENU['SUB']) ? $MENU['SUB'] : array();

                                if(!empty($SUB_ARR) && count($SUB_ARR)) {
                                    foreach($SUB_ARR as $_KEY2 => $MENU2) {
                                        $f_str .= '<li><a href="'.$MENU2["href"].'">'.$MENU2["title"].'</a></li>';
                                    }
                                }
                            }

                            $f_str .= '</li>';
                        }
                        
                        $f_str .= "</ul>";
                    }
                    echo $f_str;
                    ?>
                    <ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="#" method="post" onsubmit="return registerNewsletter();">
                        <input type="text" name="newsletter_email" placeholder="Enter your mail" />
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="<?php echo FB_LINK; ?>"><i class="fa fa-facebook"></i></a>
                        <a href="<?php echo TW_LINK; ?>"><i class="fa fa-twitter"></i></a>
                        <a href="<?php echo LI_LINK; ?>"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text"><p>
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | PetStore 
                    </p></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<?php include "_footer_links.php"; ?>
<script type="text/javascript" src="js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript">
    var ajax_url  = "<?php echo SITE_ADDRESS.'inc/ajax.inc.php'; ?>";
    function showMessage(msg="",type="error") {
        if(msg != "") {
            $.gritter.add({
                title: 'Information!',
                text: msg,
                sticky: false,
                class_name: "",
                time: 1200
            });
        }
    }

    function lbl_info(msg, type="") {
        if(msg != "") {
            erHtml = "<span class='err_info'>"+msg+"</span>";
            $('#LBL_INFO').html(erHtml);
        }
    }

    function registerNewsletter() {
        return false;
    }

    function addToWishlist(elm, productId, cust_id) {
        $.ajax({
            url: ajax_url,
            type: "post",
            data: {mode:"ADD_TO_WISHLIST", pid:productId, cid:cust_id},
            async: false,
            success: function(result) {
                res = JSON.parse(result);
                if(res.code) {
                    showMessage(res.message);
                }
            },
            error: function(errores) {
                console.log(errores.responseText);
            }
        });
    }

    function addToCart(elm, productId, cust_id) {
        $.ajax({
            url: ajax_url,
            type: "post",
            data: {mode:"ADD_TO_CART", pid:productId, cid:cust_id},
            async: false,
            success: function(result) {
                res = JSON.parse(result);
                if(res.code) {
                    showMessage(res.message);
                }
            },
            error: function(errores) {
                console.log(errores.responseText);
            }
        });
    }

    function validate_username(uname) {
        var ret = false;
        $.ajax({
            url: ajax_url,
            type: "post",
            data: {mode:"VALIDATE_CUSTOMER", username:uname},
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

        return ret;
    }

    function validiate_password(password_one, password_two) {

    }
</script>