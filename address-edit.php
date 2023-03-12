<?php
include "./inc/cu.common.php";
if(!$cust_logged || !is_numeric($sess_cust_id)) {
    ForceOutCu(3);
    exit;
}

$msg = "";
$edit_page = "address-edit.php";
$disp_page = "address.php";
$del_page = $edit_page."?m=D&id=";

// initiall value of m is ""
if(isset($_POST["mode"]) && !empty($_POST['mode'])) {
    $mode = $_POST["mode"];
}
else if(isset($_GET["mode"]) && !empty($_GET['mode'])) {
    $mode =$_GET["mode"];
}
else{
    $mode = "A";
}

//id
if(isset($_POST['id']) && is_numeric($_POST['id'])) {
    $txtid = $_POST['id'];
} 
else if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $txtid = $_GET['id'];
}
else {
    $mode = "A";
}

if($mode == 'A'){
    $txtid = 0;
    $label = "";
    $address = "";
    $form_mode = 'C';
}
else if($mode == 'C') {
    //insert
    $txtid = NextId("id", "customer_address");
    $label = $_POST["label"];
    $address = $_POST["address"];
    
    $q = "INSERT INTO customer_address(id, fkCustomerId, address, title) VALUES ($txtid, $sess_cust_id, '$address', '$label')";
    $r = sql_query($q);
    $msg = "New address has been adde"; 
    
    header("location: ".$edit_page."?mode=R&id=".$txtid);
    exit;
}
else if($mode == "R") {
    //edit
    $q = "SELECT * FROM customer_address WHERE id='$txtid'";
    $r = sql_query($q);
    $o = sql_fetch_object($r);

    $txtid = $o->id;
    $label = $o->title;
    $address = $o->address;
    $form_mode = "U";
}
else if($mode == "U"){
    //update
    $label = $_POST["label"];
    $address = $_POST["address"];
    
    $q = "UPDATE customer_address SET title='$label', address='$address' WHERE id='$txtid'";
    $r = sql_query($q);
    $msg =  "Address has been updated"; 

    header("location: ".$edit_page."?mode=R&id=".$txtid);
    exit;
}
else if($mode == "D"){
    $q = "DELETE FROM customer_address WHERE id=$txtid";
    $r = sql_query($q);

    header("location: ".$user_display);
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
                        <h2>Edit Addresses</h2>
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
    <section class="product spad address contact-form ">
        <div class="container">
            <div class="row">
                <?php include "_account_menu.php"; ?>
                <div class="col-lg-9 col-md-7">
                    <form action="<?php echo $edit_page; ?>" method="post">
                        <input type="hidden" name="mode" value="<?php echo $form_mode; ?>">
                        <input type="hidden" name="id" value="<?php echo $txtid; ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <input type="text" placeholder="Title (eg: Home, Office)" name="label" id="label" value="<?php echo $label; ?>">
                            </div>
                            <div class="col-lg-12 text-center">
                                <textarea placeholder="Address" name="address" id="address"><?php echo $address; ?></textarea>
                                <button type="submit" class="site-btn float-left">SAVE</button>
                                <button onclick="ConfirmDelete('<?php echo $del_page.$txtid; ?>', 'Address')" type="button" class="site-btn float-left c-delete">Delete</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <?php include "_footer.php"; ?>
</body>

</html>