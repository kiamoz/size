<?php

use yii\helpers\Url;
use common\models\Product;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$site_base = dirname(dirname(dirname(dirname(__FILE__))));
if (!is_numeric($_GET['id'])) {
    $_id = \common\models\ProductCategory::getProducCategorytId($_GET['id']);
} else {
    $_id = $_GET['id'];
}
$tt = \common\models\ProductCategory::findOne($_id);
$this->title = $tt->name;
?> 

<div class="main-area">
    <div class="container">
        <div class="row">
            <!--col-md-3-->
            <div class="col-md-12 col-sm-12 nopadding-left collection">
                <div class="ambit-key">
                    <div class="col-md-12 pt40">
                        <div class="breadcrumb-group">
                            <div class="breadcrumb clearfix">


                                <span><?php
                                    echo common\models\ProductCategory::breadcrumb($_id);
                                    ?>
                                </span>


                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="shop-product-area">
                        <!-- area title start -->

                        <div class="clearfix"></div>
                        <!-- area title end -->
                        <!-- product area start-->
                        <div class="row row-margin2">
                            <!-- single-product start -->
                            <?PHP
                            foreach ($cate as $product) {
                                $flag = 0;
                                $lastp = common\models\Product::get_last_price($product->product->id);
                                $has_v = common\models\Product::Hasvariant($product->product->id);
                                $has_avl = $product->product->avl;
                                $price_range = $product->product->price_range;
                                $has_v_avl = \common\models\Product::Hasvariant_avl($product->product->id);
                                $has_v_price = \common\models\Product::Hasvariant_price($product->product->id);
                                if ($product->product_category == 708) {
                                    $flag = 1;
                                }
                                ?>

                                <div class="col-md-3 col-xs-12 col-padd ">

                                    <div class="single-product tooltipp">
                                        <span class="tooltiptext tooltip_vije tipsize"><?php echo $product->product->name; ?></span>
                                        <div class="product-label">
                                            <?php if ($flag) { ?>
                                                <div class="new"></div>
                                            <?php } ?>
                                        </div>
                                        <div class="product-img">
                                            <a href="<?PHP echo Url::to(['product/view']) . "/" . $product->product->slug; ?>">
                                                <img 

                                                    <?php if ($product->product->img) { ?>
                                                        onmouseover="this.src = '<?PHP echo common\models\Post::resize_img($site_base . '/backend/web/' . $product->product->img, 340, 450, "*_*" . $product->product->id); ?>'"
                                                        onmouseout="this.src = '<?PHP echo common\models\Post::resize_img($site_base . '/backend/web/' . $product->product->thumbnail, 340, 450, "*_" . $product->product->id); ?>'"
                                                    <?php } ?>
                                                    src="<?PHP echo common\models\Post::resize_img($site_base . '/backend/web/' . $product->product->thumbnail, 340, 450, "_" . $product->product->id); ?>" alt="" title=""  />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h2 class="product-name">
                                                <a href="<?PHP echo Url::to(['product/view']) . "/" . $product->product->slug; ?>"><?php echo $product->product->name; ?></a></h2>
                                            <div class="rating">

                                            </div>
                                            <div class="price-box">
                                                <span class="new-price">
                                                    <?php
                                                    if (!$has_v) {

                                                        if ($lastp > 0 and $has_avl > 0) {
                                                            ?>
                                                            <span class="new-price">موجود</span>  
                                                            <br>
                                                            <?php
                                                            echo common\models\Product::arabic_w2e(number_format($lastp)) . 'تومان';
                                                        } elseif ($has_avl <= 0 and $lastp > 0) {
                                                            ?>
                                                            <span class="color_red">ناموجود</span>
                                                        <?php } elseif ($lastp <= 0 and $has_avl > 0) { ?>
                                                            <span class="color_orange">به زودی</span> 
                                                            <?php
                                                        }
                                                    } else {

                                                        if ($has_v_avl > 0 and $has_v_price > 0) {
                                                            ?>
                                                            <span class="new-price">موجود</span>  
                                                        <?php } elseif ($has_v_avl <= 0 and $has_v_price > 0) { ?>
                                                            <span class="color_red">نا موجود</span>  

                                                        <?php } elseif ($has_v_avl > 0 and $has_v_price <= 0) { ?>
                                                            <span class="color_orange">به زودی</span> 
                                                            <?php
                                                        }
                                                        if ($price_range) {
                                                            $exp = $price_range;
                                                            $ex_price = explode('-', $exp);
                                                            ?>
                                                            <br>
                                                            <div class="price_range">
                                                                <span>شروع قیمت  :</span>
                                                                <br>
                                                                <span> از : </span>
                                                                <span class="from"> <?php echo common\models\Product::arabic_w2e(number_format($ex_price[0])) . 'تومان '; ?>  </span>
                                                                <br>
                                                                <span> تا  : </span>
                                                                <span class="to">  <?php echo common\models\Product::arabic_w2e(number_format($ex_price[1])) . 'تومان  '; ?>  </span>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>   
                                                </span>
                                            </div>
                                            <div class="button-container mobile">
                                                <?php if ($lastp <= 0 or $has_avl <= 0) { ?>
                                                    <a href="<?PHP echo Url::to(['product/view'])."/".$product->product->slug; ?>" title="اطلاعات بیشتر"  class="button cart_button bt_cart_btn">
                                                        اطلاعات بیشتر
                                                    </a>
                                                <?php } else { ?>
                                                    <input type="hidden" value="<?= $product->product->id; ?>" class="product_id" />
                                                    <a title="افزودن به سبد خرید"  class="button cart_button bt_cart_btn add_to_card_ajaxx">
                                                        افزودن به سبد خرید
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="product-content2">

                                            <div class="button-container">
                                                <?php if ($lastp <= 0 or $has_avl <= 0) { ?>
                                                    <a href="<?PHP echo Url::to(['product/view'])."/".$product->product->slug; ?>" title="اطلاعات بیشتر"  class="button cart_button bt_cart_btn">
                                                        اطلاعات بیشتر
                                                    </a>
                                                <?php } else { ?>
                                                    <input type="hidden" value="<?= $product->product->id; ?>" class="product_id" />
                                                    <a title="افزودن به سبد خرید"  class="button cart_button bt_cart_btn add_to_card_ajaxx">
                                                        افزودن به سبد خرید
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>






                                        <ul class="add-to-links">

                                        </ul>
                                    </div>
                                </div>
                                <!-- single-product end -->
                            <?php } ?>
                        </div>
                    </div>
                    <!--shop product area end-->
                </div>
                <!--ambit-key-->
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagess,
                ]);
                ?>
            </div>
            <!--col-md-9-->
        </div>
        <!--row-->
    </div>
    <!--container-->
</div>

