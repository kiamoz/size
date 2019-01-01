<?php

use common\models\ProductHasCategory;
use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Post;
use common\models\ProductCategoryHasCategory;
use yii\widgets\LinkPager;

$site_base = dirname(dirname(dirname(dirname(__FILE__)))) . "/backend/web/";

//Post::resize_img($src, 330, 308, "_" . $product->product->id);
?>
<style>
    body:not(.electro-v1) .full_w {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-left: 15px;
        padding-right: 15px;
        flex: 0 0 100%;
        max-width: 100%;
    }

    @media (min-width:1200px) {
        .full_w {
            flex: 0 0 75%!important;
            max-width: 75% !important;
        }
    }
</style>



<div id="content" class="site-content " tabindex="-1" style="margin-top:50px;">
    <div class="container">
        <nav class="woocommerce-breadcrumb">
        </nav><div class="site-content-inner">

            <div id="sidebar" class="sidebar" role="complementary">
                <aside id="electro_product_categories_widget-1" class="widget woocommerce widget_product_categories electro_widget_product_categories" style=" min-height: 50px;">
                    <ul class="product-categories category-single">
                        <li class="product_cat">
                            <ul class="show-all-cat">
                                <li class="product_cat">
                                    <span class="show-all-cat-dropdown">
                                        مشاهده همه ی دسته بندی ها
                                        <span class="child-indicator">

                                        </span></span>

                                </li>
                            </ul>
                            <ul>

                                <li class="cat-item cat-item-106 current-cat">

                                    <ul class="children" style="display: block;">

<?php
$sitesetting = common\models\Sitesetting::findone(1);
if ($sitesetting->is_load_all_categories == 0) {
    $categoryS = ProductCategoryHasCategory::find()->with('productCategory')->where('parent_category=' . $id)->all();


    foreach ($categoryS as $category) {

        $url = Url::to(['/product/category', 'id' => $category->productCategory->id]);
        ?>
                                                <li class="cat-item cat-item-107"><a href="<?= $url ?>"><span class="no-child"><?= $category->productCategory->name ?></span></a>
                                                </li>
        <?php
    }
} else {
    $categoryS = ProductCategory::find()->all();
    foreach ($categoryS as $category) {

        $url = Url::to(['/product/category', 'id' => $category->id]);
        ?>
                                                <li class="cat-item cat-item-107"><a href="<?= $url ?>"><span class="no-child"><?= $category->name ?></span></a>
                                                </li>

        <?php
    }
}
?>


                                    </ul>
                                </li>
                            </ul></li></ul></aside>
                <aside id = "media_image-3" class = "widget widget_media_image">
                    <a href="<?=Post::findone(21)->link ?>"> 
                    <img width = "270" height = "315" src = "<?= Post::resize_img($site_base . Post::findone(21)->thumb_nail, 270, 315, "_0000"); ?>" class = "image wp-image-2142  attachment-full size-full" alt = "" style = "max-width: 100%; height: auto;">
                    </a>
                    </aside>

                <aside id = "woocommerce_products-2" class = "widget woocommerce widget_products">

                    <h3 class = "widget-title">آخرین محصولات</h3>
                    <ul class = "product_list_widget">
<?php
$latest_productS = Product::find()->orderBy(['date' => SORT_DESC])->limit(5)->all();
foreach ($latest_productS as $latest_product) {
    $src = $site_base . $latest_product->image;
    $url = Url::to(['product/view', 'id' => $latest_product->id]);
    ?>
                            <li>

                                <a href="<?= $url ?>">
                                    <img width="330" height="308" src=" <?= Post::resize_img($src, 330, 308, "_" . $latest_product->id); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="">
                                    <span class="product-title"><?= $latest_product->name ?></span>
                                </a>


                                <span class="electro-price">

                                    <span class="woocommerce-Price-amount amount"><?= Product::get_price($latest_product->id, TRUE, TRUE) ?></span></span>
                            </li>
<?php } ?>
                    </ul></aside></div>
            <div id="primary" class="content-area full_w">
                <main id="main" class="site-main">



                    <section class="section-product-categories">
                        <header>
                            <h2 class="h1"><?= \common\models\ProductCategory::findone($id)->name ?></h2>
                        </header>
                        <div class="woocommerce columns-4"><ul class="product-loop-categories columns-4">
<?php
foreach ($post_array as $product) {
    $src = $site_base . $product->product->image;
    $url = Url::to(['product/view', 'id' => $product->product->id]);
    ?>
                                    <li class="product-category product first">
                                        <a href="<?= $url ?>"><img src="<?= Post::resize_img($src, 330, 308, "_" . $product->product->id . $product->product->date); ?>" alt="Accessories" width="330" height="308">		<h2 class="woocommerce-loop-category__title">
    <?= $product->product->name ?> 		</h2>
                                        </a>
                                        <div class="product-loop-footer">
                                            <div class="price-add-to-cart">
                                                <span class="price">
                                                    <span class="electro-price">
                                                        <span class="woocommerce-Price-amount amount">
    <?= \common\models\Product::get_price($product->product->id, TRUE, TRUE) ?>    
                                                        </span></span></span>
                                                <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                    <a href="" data-quantity="1" data-id="<?= $product->product->id ?>" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2603" data-product_sku="5487FB8/25" aria-label="Add “Wireless Audio System Multiroom 360” to your cart" rel="nofollow">اضافه به سبد خرید</a></div>
                                            </div>
                                            <div class="hover-area">
                                                <div class="action-buttons">

                                                    <div class="clear"></div>
                                                </div>
                                            </div>
                                        </div>




                                    </li>
<?php } ?>



                            </ul>
<?php
echo LinkPager::widget([
    'firstPageLabel' => 'ابتدا',
    'lastPageLabel' => 'انتها',
    'prevPageLabel' => 'قبلی', // Set the label for the "previous" page button
    'nextPageLabel' => 'بعدی',
    'maxButtonCount' => 10,
    'pagination' => $page_setup,
]);
?> 
                        </div>


                    </section>




                </main><!-- #main -->
            </div><!-- #primary -->



        </div>		</div><!-- .col-full -->
</div>