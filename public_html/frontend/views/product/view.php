<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\ProductAtt;

$site_base = dirname(dirname(dirname(dirname(__FILE__)))) . "/backend/web/";

use common\models\Post;
use common\models\ProductAttGroup;

$src = $site_base . $product->image;
?>







<div class="extended">
    <div id="content" class="site-content" tabindex="-1">
        <div class="container" style="margin-top:50px;">



            <div class="site-content-inner">
                <div id="" class="content-area">
                    <main id="main" class="site-main">
                        <div id="product-2439" class="post-2439 product type-product status-publish has-post-thumbnail product_cat-headphones product_tag-fast product_tag-gaming product_tag-strong first instock taxable shipping-taxable purchasable product-type-simple">
                            <div class="single-product-wrapper">
                                <div class="product-images-wrapper">
                                    <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-5 images electro-carousel-loaded" data-columns="5" style="opacity: 1; transition: opacity 0.25s ease-in-out;">

                                        <div class="flex-viewport" style="overflow: hidden; position: relative; height: 431px;">
                                            <figure class="woocommerce-product-gallery__wrapper" style="width: 1000%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                                <div  class="woocommerce-product-gallery__image flex-active-slide" style="width: 470px; position: relative; overflow: hidden; margin-left: 0px; float: right; display: block;">
                                                    <a class=example-image-link" href="<?= Post::resize_img($src, 600, 550, "_" . $product->id . $product->date) ?>" data-lightbox="example-1">
                                                        <img class="example-image"  width="600" height="550" src="<?= Post::resize_img($src, 600, 550, "_" . $product->id . $product->date) ?>" class="wp-post-image" alt="" title="1" data-caption="" ></a>

                                                </div>

                                            </figure>
                                        </div>
                                    </div>
                                    <div id="electro-wc-product-gallery-5b20ba243731c" class="electro-wc-product-gallery electro-wc-product-gallery--with-images electro-wc-product-gallery--columns-5 images" data-columns="5">



                                     




                                        <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                            <figure class=" " style="margin-top:15px;  width: 1000%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">

                                                <?php
                                                if ($product->gallery) {
                                                    $product->gallery = trim($product->gallery);
                                                    $gallery_array = explode("\n", $product->gallery);



                                                    foreach ($gallery_array as $img_) {
                                                        ?>
                                                        <figure data-thumb="<?= $img_ ?>" class="electro-wc-product-gallery__image" style="width: 90px; margin-left: 6px; float: right; display: block;">

                                                            <a class="example-image-link" href="<?= $img_ ?>" data-lightbox="example-set" data-title=""><img class="example-image" src="<?= $img_ ?>" alt=""/></a>

                                                        </figure>


        <?php
    }
    ?>

                                                    <?php
                                                }
                                                ?>

                                            </figure>




                                        </div>
                                        <ol class="flex-control-nav flex-control-paging"></ol>
                                    </div>
                                </div>
                                <!-- /.product-images-wrapper -->
                                <div class="summary entry-summary">

                                    <h1 class="product_title entry-title">
<?= $product->name ?>
                                    </h1>
                                    <div class="woocommerce-product-rating">
                                    </div>

                                    <div class="woocommerce-product-details__short-description">
<?= $product->summery ?>
                                    </div>
                                </div>
                                <div class="product-actions-wrapper">
                                    <div class="product-actions">
                                        <div class="availability">

<?php
if ($product->qty == 1) {
    ?>
                                                <strong>   <p style="color:green; font-size: 20px">موجود</p> </strong>
                                                <p>کدکالا: <?= $product->code ?></p>
    <?php
} else {
    echo '  <p style="color:red; font-size: 20px">ناموجود</p>';
}
?>

                                            <span class="electro-stock-availability">
                                                <p class="stock in-stock">

                                                </p>
                                            </span>
                                            سایز  مورد نظر خود را انتخاب کنید
                                            <div class="wrapper" style="direction: ltr">

                                                <label for="yes_radio" id="yes-lbl">S</label><input type="radio" value="" name="choice_radio" id="yes_radio">
                                                <label for="maybe_radio" id="maybe-lbl">M</label><input type="radio" value="" name="choice_radio" id="maybe_radio" checked="checked">
                                                <label for="no_radio" id="no-lbl">L</label><input type="radio" value="" name="choice_radio" id="no_radio">


                                                <div class="toggle"></div>
                                            </div>
                                        </div>

                                        <p class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount"><?= common\models\Product::get_price($product->id, TRUE, TRUE) ?></span></span></p>

                                        <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                            <a href='' data-quantity="1"  data-id="<?= $product->id ?>"  class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2704" data-product_sku="5487FB8/34" aria-label="Add “Widescreen 4K SUHD TV” to your cart" rel="nofollow">
                                                اضافه به سبد خرید</a>
                                        </div>
                                        <div class="action-buttons">
                                            <div class="yith-wcwl-add-to-wishlist add-to-wishlist-2439">

                                                <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
                                                    <span class="feedback">Product added!</span>

                                                </div>

                                                <div style="clear:both"></div>
                                                <div class="yith-wcwl-wishlistaddresponse"></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.single-product-wrapper -->
                            <div class="electro-tabs electro-tabs-wrapper wc-tabs-wrapper">
                                <div class="electro-tab" id="tab-accessories">
                                    <div class="container">

                                    </div>
                                </div>
                                <div class="electro-tab" id="tab-description">
                                    <div class="container">
                                        <div class="tab-content">
                                            <ul class="ec-tabs">

                                                <li class="description_tab active ">
                                                    <a href="#tab-description">توضیحات</a>
                                                </li>
                                                <li class="specification_tab ">
                                                    <a href="#tab-specification">شرح محصول</a>
                                                </li>

                                            </ul>
                                            <div class="electro-description clearfix">
<?= $product->body ?>

                                            </div>
                                            <div class="product_meta">

                                                <span class="posted_in">دسته بندی: 
<?php
$categoryS = common\models\Product::get_cats_id_and_name($product->id);

foreach ($categoryS as $id => $name) {
    ?>
                                                        <a href="<?= Url::to(['product/category', 'id' => $id]) ?>" rel="tag"><?= $name ?></a>
                                                    <?php } ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="electro-tab" id="tab-specification">
                                    <div class="container">
                                        <div class="tab-content">
                                            <ul class="ec-tabs">

                                                <li class="description_tab">
                                                    <a href="#tab-description">توضیحات</a>
                                                </li>
                                                <li class="specification_tab active">
                                                    <a href="#tab-specification">شرح محصول</a>
                                                </li>

                                            </ul>

<?php
$cats_arrS = common\models\Product::get_cats_id_and_name($product->id);
foreach ($cats_arrS as $id => $name) {
    $att_groupS = \common\models\ProductCategoryHasAttGroup::find()
            ->where('category_id=' . $id)
            ->all();


    foreach ($att_groupS as $att_group) {
        $att_idS = \common\models\ProductAttGroupHasAtt::find()
                ->innerJoinWith('productAttValue')
                ->where('att_group_id=' . $att_group->att_group_id)
                ->all();
        echo "<h3>" . ProductAttGroup::findone($att_group->att_group_id)->name . "</h3>";
        echo ' <table class="table">';
        echo ' <tbody>';

        foreach ($att_idS as $att_id) {
            echo '<tr>';
            $att = Att::findone($att_id->productAttValue->att_id);
            echo '<td>' . $att->name . '</td>';


            if ($att->type == 1) {
                echo '<td>' . $att_id->productAttValue->value . '</td>';
            } elseif ($att->type == 4) {
                if ($att_id->productAttValue->value == 1) {
                    echo '  <td>   <i class="fa fa-check" aria-hidden="true"></i></td>';
                } else {
                    echo'  <td> <i class="fa fa-times" aria-hidden="true"></i></td>';
                }
            } elseif ($att->type == 5) {
                //   echo '<td>'.$att_id->productAttValue->value.'</td>';
                echo '<td>' . \common\models\AttOption::findone($att_id->productAttValue->value)->name . '</td>';
            }


            echo '</tr>';
        }


        echo ' </tbody>';
        echo '</table>';
    }
}
?>



                                        </div>
                                    </div>
                                </div>
                            </div>
                            <section class="related products">
                                <h2>محصولات مرتبط</h2>
                                <ul data-view="grid" data-toggle="regular-products" class="products columns-5">
<?php
$related_productS = common\models\Product::get_related_product($product->id, 5);
foreach ($related_productS as $related_product) {
    $src = $site_base . $related_product->product->image;
    $url = Url::to(['/product/view', 'id' => $related_product->product->id]);
    ?>
                                        <li class="post-2718 product type-product status-publish has-post-thumbnail product_cat-headphones first instock taxable shipping-taxable purchasable product-type-simple">
                                            <div class="product-outer">
                                                <div class="product-inner">
                                                    <div class="product-loop-header">
                                                        <span class="loop-product-categories">

                                                        </span>
                                                        <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                            <h2 class="woocommerce-loop-product__title"><?= $related_product->product->name ?></h2>
                                                            <div class="product-thumbnail">
                                                                <img width="330" height="308" src="<?= Post::resize_img($src, 186, 174, "_" . $related_product->product->id); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt=""></div>
                                                        </a>
                                                    </div>
                                                    <!-- /.product-loop-header -->
                                                    <div class="product-loop-body">

                                                        <a href="" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                            <h2 class="woocommerce-loop-product__title">White Solo 2 Wireless</h2>
                                                            <div class="product-rating">
                                                                <div class="star-rating" title="Rated 0 out of 5"><span style="width:0%"><strong class="rating">0</strong> out of 5</span></div>
                                                                (0)
                                                            </div>
                                                            <div class="product-short-description">
                                                                <ul>
                                                                    <li><span class="a-list-item">Pair and Play with your Bluetooth® device with 30' range</span></li>
                                                                    <li><span class="a-list-item">12 hour rechargeable battery with Fuel Gauge</span></li>
                                                                    <li><span class="a-list-item">Take hands-free calls with built-in mic*</span></li>
                                                                    <li><span class="a-list-item">Fine-tuned acoustics for clarity, breadth and balance</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="product-sku">SKU: 5487FB8/42</div>
                                                        </a>
                                                    </div>
                                                    <!-- /.product-loop-body -->
                                                    <div class="product-loop-footer">
                                                        <div class="price-add-to-cart">
                                                            <span class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount"><?= common\models\Product::get_price($related_product->product->id, TRUE, TRUE) ?></span></span></span>
                                                            <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="Add to cart" data-original-title="" title="">
                                                                <a href="/electro/product/ultra-wireless-s50-headphones-s50-with-bluetooth/?d=rtl&amp;add-to-cart=2718"  data-id="<?= $related_product->product->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2718" data-product_sku="5487FB8/42" aria-label="Add “White Solo 2 Wireless” to your cart" rel="nofollow">Add to cart</a>
                                                            </div>
                                                        </div>
                                                        <!-- /.price-add-to-cart -->
                                                        <div class="hover-area">
                                                            <div class="action-buttons">
                                                                <div class="yith-wcwl-add-to-wishlist add-to-wishlist-2718">

                                                                    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
                                                                        <span class="feedback">Product added!</span>
                                                                        <a href="" rel="nofollow">
                                                                            Browse Wishlist	        </a>
                                                                    </div>

                                                                    <div style="clear:both"></div>
                                                                    <div class="yith-wcwl-wishlistaddresponse"></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.product-loop-footer -->
                                                </div>
                                                <!-- /.product-inner -->
                                            </div>
                                            <!-- /.product-outer -->
                                        </li>

<?php } ?>

                                </ul>
                            </section>
                        </div>
                    </main>
                    <!-- #main -->
                </div>
                <!-- #primary -->
            </div>
        </div>
        <!-- .col-full -->
    </div>
</div>

