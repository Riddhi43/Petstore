<?php
include "./inc/cu.common.php";

$prod_id = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? $_GET['id'] : "";

if(empty($prod_id) || !is_numeric($prod_id)) {
	header("location: index.php");
	exit;
}

$PRODUCTS = getDataFromTable("product", "*", "and id = $prod_id");
$prodObj = $PRODUCTS[0];

$categoryId = $prodObj->categoryId;
$cat_name = GetXFromYID("SELECT title from category WHERE id = '$categoryId' ");
$productName = $prodObj->productName;
$productPrice = $prodObj->productPrice;
$productQty = $prodObj->productQty;
$productDesc = $prodObj->productDesc;
$productImg = $prodObj->productImg;

$productImgPath = (!empty($productImg) && file_exists(PROD_IMG_UPLOAD.$productImg)) ? PROD_IMG_PATH.$productImg : BLANK_IMAGE;

$cat_url = "prouduct.php?cid=".$categoryId;

$relatedProducts = array();
if(!empty($categoryId) && !empty($prod_id))
    $relatedProducts = getDataFromTable("product", "*", "and categoryId = $categoryId and id <> $prod_id");
?>
<!DOCTYPE html>
<html>

<head>
    <?php 
        site_seo($productName, '', $productDesc, $productImgPath);
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
                        <h2><?php echo $productName; ?></h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <a href="<?php echo $cat_url; ?>"><?php echo $cat_name; ?></a>
                            <span><?php echo $productName; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" width="20"
                                src="<?php echo $productImgPath; ?>" alt="<?php echo $productName; ?>">
                        </div>
                        <!-- <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl="img/product/details/product-details-2.jpg"
                                src="img/product/details/thumb-1.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-3.jpg"
                                src="img/product/details/thumb-2.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-5.jpg"
                                src="img/product/details/thumb-3.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-4.jpg"
                                src="img/product/details/thumb-4.jpg" alt="">
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $productName; ?></h3>
                        <!-- <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div> -->
                        <div class="product__details__price"><?php echo Rs.$productPrice; ?></div>
                        <p><?php echo $productDesc; ?></p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" onclick="addToCart(this,'<?php echo $prod_id; ?>', '<?php echo $sess_cust_id; ?>');"  class="primary-btn">ADD TO CART</a>
                        <a href="javascript:;" onclick="addToWishlist(this,'<?php echo $prod_id; ?>', '<?php echo $sess_cust_id; ?>');" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <ul>
                            <li><b>Availability</b> <span><?php echo ($productQty > 0) ? "In Stock" : "Out of Stock" ; ?></span></li>
                            <!-- <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            <li><b>Weight</b> <span>0.5 kg</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Reviews <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Product Infomation</h6>
                                    <p><?php echo $productDesc; ?></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Product Reviews</h6>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <?php if(count($relatedProducts) > 0) { ?>
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            	<?php
            	foreach($relatedProducts as $PROD_OBJ) {
            		$prd_id = $PROD_OBJ->id;
            		$prod_url = "product-detail.php?id=".$prd_id;
            		$cat_name = isset($PROD_CATEGORY_ARR[$PROD_OBJ->categoryId]) ? $PROD_CATEGORY_ARR[$PROD_OBJ->categoryId] : "";
            		$cat_urlname = GetUrlName($cat_name);
            		$prod_img = (!empty($PROD_OBJ->productImg) && file_exists(PROD_IMG_UPLOAD.$PROD_OBJ->productImg)) ? PROD_IMG_PATH.$PROD_OBJ->productImg : BLANK_IMAGE;
            		?>
            		<div class="col-lg-3 col-md-4 col-sm-6">
            		    <div class="product__item">
            		        <div class="product__item__pic set-bg" data-setbg="<?php echo $prod_img; ?>">
            		            <ul class="product__item__pic__hover">
            		            	<li><a onclick="addToWishlist(this,'<?php echo $prd_id; ?>', '<?php echo $sess_cust_id; ?>');" href="javascript:;"><i class="fa fa-heart"></i></a></li>
            		            	<li><a onclick="addToCart(this,'<?php echo $prd_id; ?>', '<?php echo $sess_cust_id; ?>');" href="javascript:;"><i class="fa fa-shopping-cart"></i></a></li>
            		            </ul>
            		        </div>
            		        <div class="featured__item__text">
            		        	<h6><a href="<?php echo $prod_url; ?>"><?php echo $PROD_OBJ->productName; ?></a></h6>
            		        	<h5><?php echo ($PROD_OBJ->productPrice > 0) ? Rs."&nbsp;".$PROD_OBJ->productPrice : ""; ?></h5>
            		        </div>
            		    </div>
            		</div>
            		<?php
            	}
            	?>
            </div>
        </div>
    </section>
	<?php } ?>
    <!-- Related Product Section End -->



    <?php include "_footer.php"; ?>
</body>

</html>
