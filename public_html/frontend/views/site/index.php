<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use common\models\Post;
use common\models\Category;
use common\models\ProductCategoryHasCategory;
use common\models\Product;
use common\models\ProductPrice;
use common\models\ProductCategory;
use common\models\ProductHasCategory;

$site_base = dirname(dirname(dirname(dirname(__FILE__)))) . "/backend/web/";
?>  


<div id="content" class="site-content" tabindex="-1">
    <div class="container">
        <div class="site-content-inner">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">  


                    <div class="home-v3-slider" >
                        <div id="rev_slider_14_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-source="gallery" style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
                            <!-- START REVOLUTION SLIDER 5.4.7.1 fullwidth mode -->
                            <div id="rev_slider_14_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.7.1">
                                <ul>
                                    <?php
                                    $slides = \common\models\PostHasCategory::find()->with('post')->where('category_id=12')->all();
                                    foreach ($slides as $slide) {
                                        $src = $slide->post->thumb_nail;
                                        $link = $slide->post->link;
                                        if (!$link) {
                                            $link = Url::to(['post/view', 'id' => $slide->post_id]);
                                        }
                                        ?>
                                        <!-- SLIDE  -->
                                        <li data-index="rs-<?= $slide->post->id ?>" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-thumb=""  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                                            <!-- MAIN IMAGE -->
                                             <img src="/backend/web/<?= $src;?>" />
                                        </li>
                                        <!-- SLIDE  -->
                                    <?php } ?>
                                </ul>
                                <script>var htmlDiv = document.getElementById("rs-plugin-settings-inline-css");
                                    var htmlDivCss = "";
                                    if (htmlDiv) {
                                        htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
                                    } else {
                                        var htmlDiv = document.createElement("div");
                                        htmlDiv.innerHTML = "<style>" + htmlDivCss + "</style>";
                                        document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
                                    }
                                </script>
                                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
                            </div>
                            <script>var htmlDiv = document.getElementById("rs-plugin-settings-inline-css");
                                var htmlDivCss = "";
                                if (htmlDiv) {
                                    htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
                                } else {
                                    var htmlDiv = document.createElement("div");
                                    htmlDiv.innerHTML = "<style>" + htmlDivCss + "</style>";
                                    document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
                                }
                            </script>
                            <script type="text/javascript">
                                if (setREVStartSize !== undefined)
                                    setREVStartSize(
                                            {c: '#rev_slider_14_1', responsiveLevels: [1240, 1024, 778, 480], gridwidth: [1240, 1024, 778, 680], gridheight: [417, 516, 390, 340], sliderLayout: 'fullwidth', minHeight: '185'});

                                var revapi14,
                                        tpj;
                                (function () {
                                    if (!/loaded|interactive|complete/.test(document.readyState))
                                        document.addEventListener("DOMContentLoaded", onLoad)
                                    else
                                        onLoad();

                                    function onLoad() {
                                        if (tpj === undefined) {
                                            tpj = jQuery;

                                            if ("off" == "on")
                                                tpj.noConflict();
                                        }
                                        if (tpj("#rev_slider_14_1").revolution == undefined) {
                                            revslider_showDoubleJqueryError("#rev_slider_14_1");
                                        } else {
                                            revapi14 = tpj("#rev_slider_14_1").show().revolution({
                                                sliderType: "standard",
                                                jsFileLocation: "//demo2.madrasthemes.com/electro/wp-content/plugins/revslider/public/assets/js/",
                                                sliderLayout: "fullwidth",
                                                dottedOverlay: "none",
                                                delay: 9000,
                                                navigation: {
                                                    keyboardNavigation: "off",
                                                    keyboard_direction: "horizontal",
                                                    mouseScrollNavigation: "off",
                                                    mouseScrollReverse: "default",
                                                    onHoverStop: "off",
                                                    touch: {
                                                        touchenabled: "on",
                                                        touchOnDesktop: "off",
                                                        swipe_threshold: 75,
                                                        swipe_min_touches: 1,
                                                        swipe_direction: "horizontal",
                                                        drag_block_vertical: false
                                                    }
                                                    ,
                                                    bullets: {
                                                        enable: true,
                                                        hide_onmobile: false,
                                                        style: "custom",
                                                        hide_onleave: false,
                                                        direction: "horizontal",
                                                        h_align: "center",
                                                        v_align: "bottom",
                                                        h_offset: 0,
                                                        v_offset: 25,
                                                        space: 10,
                                                        tmp: ''
                                                    }
                                                },
                                                responsiveLevels: [1240, 1024, 778, 480],
                                                visibilityLevels: [1240, 1024, 778, 480],
                                                gridwidth: [1240, 1024, 778, 680],
                                                gridheight: [417, 516, 390, 340],
                                                lazyType: "none",
                                                minHeight: "185",
                                                shadow: 0,
                                                spinner: "spinner0",
                                                stopLoop: "off",
                                                stopAfterLoops: -1,
                                                stopAtSlide: -1,
                                                shuffle: "off",
                                                autoHeight: "off",
                                                disableProgressBar: "on",
                                                hideThumbsOnMobile: "off",
                                                hideSliderAtLimit: 0,
                                                hideCaptionAtLimit: 0,
                                                hideAllCaptionAtLilmit: 0,
                                                debugMode: false,
                                                fallbacks: {
                                                    simplifyAll: "off",
                                                    nextSlideOnWindowFocus: "off",
                                                    disableFocusListener: false,
                                                }
                                            });
                                        }
                                        ; /* END OF revapi call */

                                    }
                                    ; /* END OF ON LOAD FUNCTION */
                                }()); /* END OF WRAPPING FUNCTION */
                            </script>
                            <script>
                                var htmlDivCss = unescape("%40media%20%28max-width%3A%201200px%29%20and%20%28min-width%3A%20900px%29%7B%0A%09.tp-revslider-mainul%20li%3Anth-child%282%29%20div%3Anth-child%282%29%2C%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%282%29%20div%3Anth-child%283%29%2C%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%282%29%20div%3Anth-child%284%29%2C%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%282%29%20div%3Anth-child%286%29%2C%0A%09.tp-revslider-mainul%20li%3Afirst-child%20div%3Anth-child%282%29%2C%20%0A%20%20%20%20.tp-revslider-mainul%20li%3Afirst-child%20div%3Anth-child%283%29%2C%20%0A%20%20%20%20.tp-revslider-mainul%20li%3Afirst-child%20div%3Anth-child%284%29%2C%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%283%29%20div%3Anth-child%283%29%2C%20%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%283%29%20div%3Anth-child%284%29%2C%20%0A%20%20%20%20.tp-revslider-mainul%20li%3Anth-child%283%29%20div%3Anth-child%285%29%20%7B%0A%20%20%20%20%20%20%20%20left%3A%2060px%20%21important%3B%0A%20%20%20%20%7D%0A%7D");
                                var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
                                if (htmlDiv) {
                                    htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
                                } else {
                                    var htmlDiv = document.createElement('div');
                                    htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
                                    document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
                                }

                            </script>
                            <script>
                                var htmlDivCss = unescape(".custom.tp-bullets%20%7B%0A%7D%0A.custom.tp-bullets%3Abefore%20%7B%0A%09content%3A%22%20%22%3B%0A%09position%3Aabsolute%3B%0A%09width%3A100%25%3B%0A%09height%3A100%25%3B%0A%09background%3Atransparent%3B%0A%09padding%3A10px%3B%0A%09margin-left%3A-10px%3Bmargin-top%3A-10px%3B%0A%09box-sizing%3Acontent-box%3B%0A%7D%0A.custom%20.tp-bullet%20%7B%0A%09width%3A12px%3B%0A%09height%3A12px%3B%0A%09position%3Aabsolute%3B%0A%09background%3A%23aaa%3B%0A%20%20%20%20background%3Argba%28125%2C125%2C125%2C0.5%29%3B%0A%09cursor%3A%20pointer%3B%0A%09box-sizing%3Acontent-box%3B%0A%7D%0A.custom%20.tp-bullet%3Ahover%2C%0A.custom%20.tp-bullet.selected%20%7B%0A%09background%3Argb%28125%2C125%2C125%29%3B%0A%7D%0A.custom%20.tp-bullet-image%20%7B%0A%7D%0A.custom%20.tp-bullet-title%20%7B%0A%7D%0A%0A");
                                var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
                                if (htmlDiv) {
                                    htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
                                } else {
                                    var htmlDiv = document.createElement('div');
                                    htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
                                    document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
                                }

                            </script>
                        </div>
                        <!-- END REVOLUTION SLIDER -->		
                    </div>
                    <div class="home-v3-features-block animate-in-view" data-animation="fadeIn">
                        <div class="features-list columns-5">
                            <div class="feature">
                                <div class="media">
                                    <div class="media-left media-middle feature-icon">
                                        <i class="ec ec-transport"></i>
                                    </div>
                                    <div class="media-body media-middle feature-text">
                                        <?= Post::findone(5)->body ?>					
                                    </div>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="media">
                                    <div class="media-left media-middle feature-icon">
                                        <i class="ec ec-customers"></i>
                                    </div>
                                    <div class="media-body media-middle feature-text">
                                        <?= Post::findone(6)->body ?>						
                                    </div>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="media">
                                    <div class="media-left media-middle feature-icon">
                                        <i class="ec ec-returning"></i>
                                    </div>
                                    <div class="media-body media-middle feature-text">
                                        <?= Post::findone(7)->body ?>						
                                    </div>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="media">
                                    <div class="media-left media-middle feature-icon">
                                        <i class="ec ec-payment"></i>
                                    </div>
                                    <div class="media-body media-middle feature-text">
                                        <?= Post::findone(8)->body ?>						
                                    </div>
                                </div>
                            </div>
                            <div class="feature">
                                <div class="media">
                                    <div class="media-left media-middle feature-icon">
                                        <i class="ec ec-tag"></i>
                                    </div>
                                    <div class="media-body media-middle feature-text">
                                        <?= Post::findone(9)->body ?>						
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $banner_post_right = Post::findone(12);
                    $src = $site_base . $banner_post_right->thumb_nail;
                    ?>
                    <div class="home-v3-da-block animate-in-view" data-animation=" animated fadeIn">
                        <div class="da-block columns-2">
                            <div class="da">
                                <div class="da-inner">
                                    <a class="da-media" href="<?= $banner_post_right->link ?>">
                                        <div class="da-media-left"><img src="<?= Post::resize_img($src, 374, 211, "_" . $banner_post_right->id . $banner_post_right->update_date); ?>" alt="" /></div>
                                        <div class="da-media-body">
                                            <div class="da-text">
                                                <?= $banner_post_right->body ?>						
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="da">
                                <?php
                                $banner_post_left = Post::findone(11);
                                $src = $site_base . $banner_post_left->thumb_nail;
                                ?>
                                <div class="da-inner">
                                    <a class="da-media" href="<?= $banner_post_left->link ?>">
                                        <div class="da-media-left"><img src="<?= Post::resize_img($src, 374, 211, "_" . $banner_post_left->id . $banner_post_left->update_date); ?>" alt="" /></div>
                                        <div class="da-media-body">
                                            <div class="da-text">
                                                <?= $banner_post_left->body ?>							
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>
                <!-- #main -->
            </div>
            <!-- #primary -->
        </div>

        <!-- .col-full -->




        <div class="tabs-block">
            <div class="products-carousel-tabs">
                <ul class="nav nav-inline">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab-products-1" data-toggle="tab">
                            <?= \common\models\ProductCategory::findone(747)->name; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-products-2" data-toggle="tab">
                            <?= \common\models\ProductCategory::findone(748)->name; ?>			</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-products-3" data-toggle="tab">
                            <?= \common\models\ProductCategory::findone(749)->name; ?>			</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-products-1" role="tabpanel">
                        <div class="woocommerce columns-3 ">
                            <ul data-view="grid" data-toggle="regular-products" class="products columns-3">
                                <?php
                                $productS = \common\models\ProductHasCategory::find()->innerJoinWith('product')->where('product_category=747')->limit(3)->all();
                                foreach ($productS as $product) {
                                    $url = Url::to(['product/view', 'id' => $product->product->id]);
                                    $src = $site_base . $product->product->image;
                                    ?>
                                    <li class="post-2603 product type-product status-publish has-post-thumbnail product_cat-audio-speakers first instock taxable shipping-taxable purchasable product-type-simple">
                                        <div class="product-outer">
                                            <div class="product-inner">
                                                <div class="product-loop-header">
                                                    <span class="loop-product-categories">
                                                        <?php
                                                        $category = ProductHasCategory::find()->innerJoinWith('productCategory')->where('product_id=' . $product->product->id)->one();
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $category->productCategory->id]) ?>" rel="tag"><?= $category->productCategory->name ?></a>

                                                    </span>
                                                    <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                        <h2 class="woocommerce-loop-product__title"><?= $product->product->name ?></h2>
                                                        <div class="product-thumbnail"><img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, '_' . $product->product->name) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt=""></div>
                                                    </a>
                                                </div>
                                                <!-- /.product-loop-header -->

                                                <!-- /.product-loop-body -->
                                                <div class="product-loop-footer">
                                                    <div class="price-add-to-cart">
                                                        <span class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount"><?= Product::get_price($product->product->id) ?></span></span></span>
                                                        <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                            <a href="" data-id="<?= $product->product->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2682" data-product_sku="5487FB8/29" aria-label="Read more about “Smartwatch 2.0 LTE Wifi”" rel="nofollow">اضافه به سبد خرید</a>
                                                        </div>
                                                    </div>
                                                    <!-- /.price-add-to-cart -->

                                                </div>
                                                <!-- /.product-loop-footer -->
                                            </div>
                                            <!-- /.product-inner -->
                                        </div>
                                        <!-- /.product-outer -->
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab-products-2" role="tabpanel">
                        <div class="woocommerce columns-3 ">
                            <ul data-view="grid" data-toggle="regular-products" class="products columns-3">
                                <?php
                                $productS = \common\models\ProductHasCategory::find()->innerJoinWith('product')->where('product_category=748')->limit(3)->all();
                                foreach ($productS as $product) {
                                    $url = Url::to(['product/view', 'id' => $product->product->id]);
                                    $src = $site_base . $product->product->image;
                                    ?>
                                    <li class="post-2603 product type-product status-publish has-post-thumbnail product_cat-audio-speakers first instock taxable shipping-taxable purchasable product-type-simple">
                                        <div class="product-outer">
                                            <div class="product-inner">
                                                <div class="product-loop-header">
                                                    <span class="loop-product-categories">
                                                        <?php
                                                        $category = ProductHasCategory::find()->innerJoinWith('productCategory')->where('product_id=' . $product->product->id)->one();
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $category->productCategory->id]) ?>" rel="tag"><?= $category->productCategory->name ?></a>

                                                    </span>
                                                    <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                        <h2 class="woocommerce-loop-product__title"><?= $product->product->name ?></h2>
                                                        <div class="product-thumbnail"><img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, '_' . $product->product->name) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt=""></div>
                                                    </a>
                                                </div>
                                                <!-- /.product-loop-header -->

                                                <!-- /.product-loop-body -->
                                                <div class="product-loop-footer">
                                                    <div class="price-add-to-cart">
                                                        <span class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount"><?= Product::get_price($product->product->id) ?></span></span></span>
                                                        <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                            <a href="" data-id="<?= $product->product->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2682" data-product_sku="5487FB8/29" aria-label="Read more about “Smartwatch 2.0 LTE Wifi”" rel="nofollow">اضافه به سبد خرید</a>
                                                        </div>
                                                    </div>
                                                    <!-- /.price-add-to-cart -->

                                                </div>
                                                <!-- /.product-loop-footer -->
                                            </div>
                                            <!-- /.product-inner -->
                                        </div>
                                        <!-- /.product-outer -->
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab-products-3" role="tabpanel">
                        <div class="woocommerce columns-3 ">
                            <ul data-view="grid" data-toggle="regular-products" class="products columns-3">
                                <?php
                                $productS = \common\models\ProductHasCategory::find()->innerJoinWith('product')->where('product_category=749')->limit(3)->all();
                                foreach ($productS as $product) {
                                    $url = Url::to(['product/view', 'id' => $product->product->id]);
                                    $src = $site_base . $product->product->image;
                                    ?>
                                    <li class="post-2603 product type-product status-publish has-post-thumbnail product_cat-audio-speakers first instock taxable shipping-taxable purchasable product-type-simple">
                                        <div class="product-outer">
                                            <div class="product-inner">
                                                <div class="product-loop-header">
                                                    <span class="loop-product-categories">
                                                        <?php
                                                        $category = ProductHasCategory::find()->innerJoinWith('productCategory')->where('product_id=' . $product->product->id)->one();
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $category->productCategory->id]) ?>" rel="tag"><?= $category->productCategory->name ?></a>

                                                    </span>
                                                    <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                        <h2 class="woocommerce-loop-product__title"><?= $product->product->name ?></h2>
                                                        <div class="product-thumbnail"><img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, '_' . $product->product->name) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt=""></div>
                                                    </a>
                                                </div>
                                                <!-- /.product-loop-header -->

                                                <!-- /.product-loop-body -->
                                                <div class="product-loop-footer">
                                                    <div class="price-add-to-cart">
                                                        <span class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount"><?= Product::get_price($product->product->id) ?></span></span></span>
                                                        <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                            <a href="" data-id="<?= $product->product->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2682" data-product_sku="5487FB8/29" aria-label="Read more about “Smartwatch 2.0 LTE Wifi”" rel="nofollow">اضافه به سبد خرید</a>
                                                        </div>
                                                    </div>
                                                    <!-- /.price-add-to-cart -->

                                                </div>
                                                <!-- /.product-loop-footer -->
                                            </div>
                                            <!-- /.product-inner -->
                                        </div>
                                        <!-- /.product-outer -->
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- #content -->
        <section class="products-2-1-2 animate-in-view fadeIn animated" data-animation="fadeIn">
            <h2 class="sr-only">Products Grid</h2>
            <div class="container">

                <ul class="nav nav-inline nav-justified">
                    <li class="nav-item"><a href="#" class="active nav-link"><?= common\models\ProductCategory::findone(743)->name ?></a></li>
                    <?php
                    $index_categoryS = ProductCategoryHasCategory::find()->innerJoinWith('productCategory')->where('parent_category=743')->orderBy(['date' => SORT_DESC])->limit(8)->all();

                    foreach ($index_categoryS as $index_category) {
                        ?>

                        <li class="nav-item"><a href="<?= Url::to(['product/category', 'id' => $index_category->productCategory->id]) ?>" class=" nav-link"><?= $index_category->productCategory->name ?></a></li>

                    <?php } ?>


                </ul>



                <div class="columns-2-1-2">
                    <div class="products-2 products-2-left">
                        <ul class="products exclude-auto-height columns-1">
                            <?php
                            $products_leftS = Product::find()->orderBy(['date' => SORT_DESC])->limit(2)->all();
                            foreach ($products_leftS as $products_left) {
                                $src = $site_base . $products_left->image;
                                $url = Url::to(['product/view', 'id' => $products_left->id]);
                                ?>
                                <li class="post-2682 product type-product status-publish has-post-thumbnail product_cat-smartwatches first outofstock taxable shipping-taxable purchasable product-type-simple">
                                    <div class="product-outer">
                                        <div class="product-inner">
                                            <div class="product-loop-header">
                                                <span class="loop-product-categories">
                                                    <?php
                                                    $catS = common\models\Product::get_cats_id_and_name($products_left->id);
                                                    foreach ($catS as $id => $name) {
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $id]) ?>" rel="tag"><?= $name ?></a>
                                                    <?php } ?>
                                                </span>
                                                <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                    <h2 class="woocommerce-loop-product__title">
                                                        <?= $products_left->name ?>
                                                    </h2>
                                                    <div class="product-thumbnail">
                                                        <img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, "_" . $products_left->id) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="">
                                                    </div>
                                                </a>
                                            </div><!-- /.product-loop-header -->
                                            <div class="product-loop-body">
                                                <span class="loop-product-categories">
                                                    <a href="" rel="tag">

                                                        <?= Product::getCategory_name($products_left->id) ?>
                                                    </a>
                                                </span>


                                            </div><!-- /.product-loop-body -->
                                            <div class="product-loop-footer">
                                                <div class="price-add-to-cart">
                                                    <span class="price">
                                                        <span class="electro-price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol"> </span>
                                                                <?= Product::get_price($products_left->id, TRUE, TRUE) ?>
                                                            </span>

                                                        </span>

                                                    </span>
                                                    <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                        <a href="" data-id="<?= $products_left->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2682" data-product_sku="5487FB8/29" aria-label="Read more about “Smartwatch 2.0 LTE Wifi”" rel="nofollow">Read more</a>
                                                    </div>
                                                </div><!-- /.price-add-to-cart -->

                                            </div><!-- /.product-loop-footer -->
                                        </div><!-- /.product-inner -->
                                    </div><!-- /.product-outer -->
                                </li>

                            <?php } ?>
                        </ul></div>
                    <div class="products-1"><ul class="products exclude-auto-height columns-1 product-main-2-1-2 show-btn">
                            <?php
                            $products_middle = Product::find()->orderBy(['date' => SORT_DESC])->offset(2)->one();
                            $url = Url::to(['product/view', 'id' => $products_middle->id]);
                            $src = $site_base . $products_middle->image;
                            ?>
                            <li class="post-2704 product type-product status-publish has-post-thumbnail product_cat-tvs  instock sale taxable shipping-taxable purchasable product-type-simple">
                                <div class="product-outer">
                                    <div class="product-inner">
                                        <div class="flex-div">
                                            <div class="product-loop-header">
                                                <span class="loop-product-categories">
                                                    <?php
                                                    $catS = common\models\Product::get_cats_id_and_name($products_middle->id);
                                                    foreach ($catS as $id => $name) {
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $id]) ?>" rel="tag"><?= $name ?></a>
                                                    <?php } ?>
                                                </span>
                                                <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                    <h2 class="woocommerce-loop-product__title"><?= $products_middle->name ?></h2></a></div><!-- /.product-loop-header -->
                                            <div class="product-thumbnail">
                                                <img width="600" height="550" src="<?= Post::resize_img($src, 600, 550, "_" . $products_middle->id) ?>" class="attachment-shop_single size-shop_single wp-post-image" alt=""></div><div class="product-loop-body"><span class="loop-product-categories"><a href="" rel="tag">TVs</a></span><a href="" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><h2 class="woocommerce-loop-product__title">Widescreen 4K SUHD TV</h2>	

                                                </a></div><!-- /.product-loop-body -->
                                                <div class="product-loop-footer">
                                                <div class="price-add-to-cart">
                                                    <span class="price">
                                                        <span class="electro-price">
                                                            <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">

                                                                    </span>

                                                                </span></ins> 
                                                            <span class="woocommerce-Price-amount amount"> <?= Product::get_price($products_middle->id, TRUE, TRUE) ?></span>

                                                        </span></span>
                                                    <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                        <a href='' data-quantity="1"  data-id="<?= $products_middle->id ?>"  class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2704" data-product_sku="5487FB8/34" aria-label="Add “Widescreen 4K SUHD TV” to your cart" rel="nofollow">
                                                            اضافه به سبد خرید</a>
                                                    </div>
                                                </div><!-- /.price-add-to-cart --></div><!-- /.product-loop-footer --></div><!-- /.flex-div --> 

                                    </div><!-- /.product-inner -->
                                </div><!-- /.product-outer -->
                            </li>
                        </ul>
                    </div>
                    <div class="products-2 products-2-right">
                        <ul class="products exclude-auto-height columns-1">
                            <?php
                            $products_rightS = Product::find()->orderBy(['date' => SORT_DESC])->offset(3)->limit(2)->all();
                            foreach ($products_rightS as $products_right) {
                                $src = $site_base . $products_right->image;
                                $url = Url::to(['product/view', 'id' => $products_right->id])
                                ?>

                                <li class="post-2702 product type-product status-publish has-post-thumbnail product_cat-cameras first instock taxable shipping-taxable purchasable product-type-simple">
                                    <div class="product-outer">
                                        <div class="product-inner">
                                            <div class="product-loop-header">
                                                <span class="loop-product-categories">
                                                    <?php
                                                    $catS = common\models\Product::get_cats_id_and_name($products_right->id);
                                                    foreach ($catS as $id => $name) {
                                                        ?>
                                                        <a href="<?= Url::to(['/product/category', 'id' => $id]) ?>" rel="tag"><?= $name ?></a>
                                                    <?php } ?>
                                                </span>
                                                <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><h2 class="woocommerce-loop-product__title">
                                                        <?= $products_right->name ?>
                                                    </h2>
                                                    <div class="product-thumbnail">
                                                        <img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, "_" . $products_right->id) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="">
                                                    </div>
                                                </a>
                                            </div><!-- /.product-loop-header -->
                                            <div class="product-loop-body">
                                                <span class="loop-product-categories">
                                                    <a href="https://demo2.madrasthemes.com/electro/product-category/cameras-photography/cameras/" rel="tag">Cameras</a></span><a href="https://demo2.madrasthemes.com/electro/product/camera-c430w-4k-with-waterproof-cover/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><h2 class="woocommerce-loop-product__title">Camera C430W 4k with  Waterproof cover</h2>		<div class="product-rating">
                                                    </div>
                                                </a></div><!-- /.product-loop-body -->
                                            <div class="product-loop-footer"><div class="price-add-to-cart">
                                                    <span class="price"><span class="electro-price"><span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">

                                                                </span>
                                                                <?= Product::get_price($products_right->id, TRUE, TRUE) ?>
                                                            </span>

                                                        </span></span>
                                                    <div class="add-to-cart-wrap"  data-id="<?= $products_right->id ?>" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title=""><a href=""   data-id="<?= $products_right->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2702" data-product_sku="5487FB8/33" aria-label="Add “Camera C430W 4k with  Waterproof cover” to your cart" rel="nofollow">اضافه به سبد خرید</a></div></div><!-- /.price-add-to-cart -->

                                            </div><!-- /.product-loop-footer --></div><!-- /.product-inner --></div><!-- /.product-outer --></li>
                            <?php } ?>
                        </ul></div>
                </div>

            </div>
        </section>




        <section class="section-products-carousel ">
            <header>
                <h2 class="h1">
                    <?php
                    echo \common\models\ProductCategory::findone(746)->name;
                    $productS = \common\models\ProductHasCategory::find()->innerJoinWith('product')->where('product_category=746')->all()
                    ?>

                </h2>
                <div class="owl-nav">
                    <a href="#products-carousel-prev" data-target="#products-carousel-5b336a4a8c31e" class="slider-prev"><i class="fa fa-angle-right"></i></a>
                    <a href="#products-carousel-next" data-target="#products-carousel-5b336a4a8c31e" class="slider-next"><i class="fa fa-angle-left"></i></a>
                </div>
            </header>
            <div class="woocommerce columns-6 ">
                <div class="owl-stage-outer">
                    <div  id="product_x" class="owl-carousel owl-rtl">



                        <?php
                        foreach ($productS as $product) {
                            $url = Url::to(['product/view', 'id' => $product->product->id]);
                            $src = $site_base . $product->product->image;
                            ?>

                            <div class="owl-item active" style="width: 240.333px;">
                                <div class="post-2439 product type-product status-publish has-post-thumbnail product_cat-headphones product_tag-fast product_tag-gaming product_tag-strong  instock taxable shipping-taxable purchasable product-type-simple">
                                    <div class="product-outer">
                                        <div class="product-inner">
                                            <div class="product-loop-header">
                                                <span class="loop-product-categories">
                                                    <?php
                                                    $category = ProductHasCategory::find()->innerJoinWith('productCategory')->where('product_id=' . $product->product->id)->one();
                                                    ?>
                                                    <a href="<?= Url::to(['/product/category', 'id' => $category->productCategory->id]) ?>" rel="tag"><?= $category->productCategory->name ?></a>

                                                </span>
                                                <a href="<?= $url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                    <h2 class="woocommerce-loop-product__title"><?= $product->product->name ?></h2>
                                                    <div class="product-thumbnail">
                                                        <img width="330" height="308" src="<?= Post::resize_img($src, 330, 308, '_' . $product->product->id) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="">
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- /.product-loop-header -->

                                            <!-- /.product-loop-body -->

                                            <div class="product-loop-footer">
                                                <div class="price-add-to-cart">
                                                    <span class="price">
                                                        <span class="electro-price"><span class="woocommerce-Price-amount amount"><?= Product::get_price($product->product->id) ?></span></span></span>
                                                    <div class="add-to-cart-wrap" data-toggle="tooltip" data-title="اضافه به سبد خرید" data-original-title="" title="">
                                                        <a href="" data-id="<?= $product->product->id ?>" data-quantity="1" class="button product_type_simple add_to_cart_button add_to_card_ajax_avis" data-product_id="2682" data-product_sku="5487FB8/29" aria-label="Read more about “Smartwatch 2.0 LTE Wifi”" rel="nofollow">Read more</a>
                                                    </div>
                                                </div>
                                                <!-- /.price-add-to-cart -->

                                            </div>
                                            <!-- /.product-loop-footer -->
                                        </div>
                                        <!-- /.product-inner -->
                                    </div>
                                    <!-- /.product-outer -->
                                </div>
                            </div> 



                        <?php } ?>


                    </div>



                </div>

            </div>
        </section>

    </div>




</div>
</div>