<?php
include "./inc/cu.common.php";
if(!$cust_logged || !is_numeric($sess_cust_id)) {
    ForceOutCu(3);
    exit;
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

     <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>My Addresses</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Addresses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

     <!-- Product Section Begin -->
    <section class="product spad address">
        <div class="container">
            <div class="row">
                <?php include "_account_menu.php"; ?>
                <div class="col-lg-9 col-md-7">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <a href="address-edit.php" class="site-btn">ADD ADDRESS</a>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $addresses = getDataFromTable("customer_address", "id, address, title", "and fkCustomerId = $sess_cust_id");

                        if(!empty($addresses) && count($addresses)) {
                            foreach($addresses as $_ADR) {
                                $a_url = "address-edit.php?mode=R&id=".$_ADR->id;
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                                    <a href="<?php echo $a_url; ?>">
                                    <div class="contact__widget">
                                        <span class="icon_pin_alt"></span>
                                        <h4><?php echo $_ADR->title; ?></h4>
                                        <p><?php echo $_ADR->address; ?></p>
                                    </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <?php include "_footer.php"; ?>
    <script type="text/javascript">
        var m = "<?php echo $msg; ?>";
        if(m != "") {
            showMessage(m);
        }
    </script>
</body>

</html>