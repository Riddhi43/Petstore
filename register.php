<?php
include "./inc/cu.common.php";

$msg = "";
if(isset($_GET['err']) && !empty($_GET['err'])) {
    $er = $_GET['err'];
    if($er == '2') {
        $msg = "Something went wrong, we could not register you!";
    }
}

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

    <div class="container-fluied my-3">
        <div id="LBL_INFO" class="text-center"></div>
        <h2 class="text-center">Sign Up</h2>
        <div class=" row d-flex align-items-center justify-content-center">
            <div class="col-lg-6 col-xl-6">
                <form action="custregister.php" method="post" autocomplete="off" id="register_form" onsubmit="return validateForm(this);">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Full Name<span>*</span></p>
                                <input type="text" name="txtname" id="txtname" value="" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Email Id<span>*</span></p>
                                <input type="email" name="txtemail" id="txtemail" value="" required />
                            </div>
                        </div>
                    </div>
                    <div class="checkout__textarea">
                        <p>Address<span>*</span></p>
                        <textarea required name="txtaddress" id="txtaddress"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Username<span>*</span></p>
                                <input type="text" name="txtusername" id="txtusername" value="" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Password<span>*</span></p>
                                <input type="password" name="txtpassword" id="txtpassword" value="" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="small">Already have an account? <a href="login.php">Sign In</a></p>
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="site-btn">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "_footer.php"; ?>
    <script type="text/javascript">
        function validateForm(frm) {
            valid_username = validate_username($("#txtusername").val());

            return valid_username;
        }

        $(document).ready(function() {
            lbl_info("<?php echo $msg; ?>");
        });
    </script>
</body>
</html>