<?php
include "./inc/cu.common.php";

$msg = "";
if(isset($_GET['err']) && !empty($_GET['err'])) {
    $er = $_GET['err'];
    if($er == '1') {
        $msg = "Registered successfully! Login to continue.";
    }
    else if($er == '2') {
        $msg = "No password entered.";
    }
    else if($er == "3") {
        $msg = "No username entered.";   
    }
    else if($er == "4") {
        $msg = "Incorrect password entered.";   
    }
    else if($er == "5") {
        $msg = "Invalid Username.";   
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
        <h2 class="text-center">Login</h2>
        <div class=" row d-flex align-items-center justify-content-center">
            <div class="col-lg-4 col-xl-4">
                <form action="custlogin.php" method="post">
                    <div class="form-outline mb-3">
                        <!-- username field-->
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" placeholder="Userame" class="form-control" name="user_username" autocomplete="off" required="required">
                    </div>
                    <div class="form-outline mb-3">
                        <!-- password field-->
                        <label for="user_password">Password</label>
                        <input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" autocomplete="off" required="required">
                    </div>
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="site-btn">LOGIN</button>
                    </div>
                    <div class="text-center">
                        <p class="small">Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php include "_footer.php"; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            lbl_info("<?php echo $msg; ?>");
        });
    </script>
</body>
</html>