<?php
include "./inc/cu.common.php";
$cat_id = (isset($_GET['cid']) && is_numeric($_GET['cid']) ) ? $_GET['cid'] : "";
$prod_cond = "";
$cat_name = GetXFromYID("SELECT title from category WHERE id = '$cat_id' ");
if(!empty($cat_id) && !empty($cat_name)) {
    $prod_cond = " AND categoryId = $cat_id";
}

$PRODUCTS = getDataFromTable("product", "*", $prod_cond);
$prod_count = count($PRODUCTS);
?>
<!DOCTYPE html>
<html>

<head>
    <?php 
        site_seo($cat_name);
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
                        <h2>Petstore Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <?php
                            echo !empty($cat_name) ? "<a href='product.php?cid=".$cat_id."'>".$cat_name."</a>" : "";
                            ?>
                            <span>Products</span>
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
                <?php if(empty($cat_id)) { ?>
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Categories</h4>
                            <ul>
                                <?php
                                if(!empty($PROD_CATEGORY)) {
                                    foreach($PROD_CATEGORY as $P_OBJ) {
                                        $urlname = GetUrlName($P_OBJ->title);
                                        $cat_url = "product.php?cid=".$P_OBJ->id;
                                        echo '<li><a href="'.$cat_url.'">'.$P_OBJ->title.'</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="<?php echo empty($cat_id) ? 'col-lg-9 col-md-7' : 'col-lg-12 col-md-12'; ?>" >
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span><?php echo $prod_count; ?></span> Products found</h6>
                                </div>
                            </div>
                            <!-- <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if(!empty($PRODUCTS)) {
                            foreach($PRODUCTS as $PROD_OBJ) {
                                $prd_id = $PROD_OBJ->id;
                                $prod_url = "product-detail.php?id=".$prd_id;
                                $prod_price = (!empty($PROD_OBJ->productPrice)) ? Rs.$PROD_OBJ->productPrice : "";
                                $prod_img = (!empty($PROD_OBJ->productImg) && file_exists(PROD_IMG_UPLOAD.$PROD_OBJ->productImg) ) ? PROD_IMG_PATH.$PROD_OBJ->productImg : BLANK_IMAGE;
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="<?php echo $prod_img; ?>">
                                            <ul class="product__item__pic__hover">
                                                <li><a onclick="addToWishlist(this,'<?php echo $prd_id; ?>', '<?php echo $sess_cust_id; ?>');" href="javascript:;"><i class="fa fa-heart"></i></a></li>
                                                <li><a onclick="addToCart(this,'<?php echo $prd_id; ?>', '<?php echo $sess_cust_id; ?>');" href="javascript:;"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="<?php echo $prod_url; ?>"><?php echo $PROD_OBJ->productName; ?></a></h6>
                                            <h5><?php echo $prod_price; ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                   <!--  <div class="product__pagination">
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <?php include "_footer.php"; ?>
</body>

</html>