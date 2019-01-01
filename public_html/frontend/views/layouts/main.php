<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use common\models\Category;
use common\models\Post;
use common\models\Sitesetting;
use common\models\ProductOrder;

$sitesetting = Sitesetting::findone(1);
$m = $sitesetting;
$site_base = dirname(dirname(dirname(dirname(__FILE__)))) . "/backend/web/";
?>
<!DOCTYPE html>
<?php $this->beginPage() ?>
<?php

function get_item_name($item_id) { // need pass by reference 
    if (substr($item_id, 0, 1) == "p") {


        return Post::findOne(substr($item_id, 2))->title;
    } elseif (substr($item_id, 0, 1) == "f") {


        return common\models\Form::findOne(substr($item_id, 2))->name;
    } elseif (substr($item_id, 0, 1) == "c") {

        return Category::findOne(substr($item_id, 2))->name;
    } else {

        return common\models\ProductCategory::findOne(substr($item_id, 2))->name;
    }
}

function get_item_link($item_id) { // need pass by reference 
    if (substr($item_id, 0, 1) == "p") {

        return Url::to(['post/view']) . "/" . substr($item_id, 2);
    } elseif (substr($item_id, 0, 1) == "f") {


        return Url::to(['site/form']) . "/" . substr($item_id, 2);
    } elseif (substr($item_id, 0, 1) == "c") {

        return Url::to(['post/category']) . "/" . substr($item_id, 2);
    } else {

        return Url::to(['product/category']) . "/" . substr($item_id, 2);
    }
}

$array = ((json_decode($m->option_value)));
?>
<html dir="rtl" lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="stylesheet" type="text/css" href="/costumcss.css?ver=<?= rand(1, 999999) ?>">

        <script type="text/javascript">document.documentElement.className = document.documentElement.className + ' yes-js js_active js'</script>
        <title><?= $sitesetting->title ?></title>
        <meta name='robots' content='noindex,follow' />
        <link rel='dns-prefetch' href='//fonts.googleapis.com' />
        <link rel='dns-prefetch' href='//s.w.org' />
        <style type="text/css">
            img.wp-smiley,
            img.emoji {
                display: inline !important;
                border: none !important;
                box-shadow: none !important;
                height: 1em !important;
                width: 1em !important;
                margin: 0 .07em !important;
                vertical-align: -0.1em !important;
                background: none !important;
                padding: 0 !important;
            }
        </style>

        <link rel='stylesheet' id='contact-form-7-css'  href='/js_css/contact_form_styles.css' type='text/css' media='all' />
        <link rel='stylesheet' id='contact-form-7-rtl-css'  href='/js_css/contact_form_styles-rtl.css' type='text/css' media='all' />
        <link rel='stylesheet' id='rs-plugin-settings-css'  href='/js_css/contact_form_settings.css' type='text/css' media='all' />
        <style id='rs-plugin-settings-inline-css' type='text/css'>
            #rs-demo-id {}
        </style>
        <link rel='stylesheet' id='jquery-colorbox-css'  href='/js_css/colorbox.css' type='text/css' media='all' />
        <link rel='stylesheet' id='bootstrap-css'  href='/js_css/bootstrap.min.css' type='text/css' media='all' />

        <link rel='stylesheet' id='animate-css'  href='/js_css/animate.min.css' type='text/css' media='all' />
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link rel='stylesheet' id='bootstrap-rtl-css'  href='/js_css/bootstrap-rtl.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='bootstrap-rtl-css'  href='/js_css/fonts.css?ver=6' type='text/css' media='all' />
        <link rel='stylesheet'  href='/js_css/tracking.css' type='text/css' />
         <link rel='stylesheet'  href='/js_css/smoothproducts.css' type='text/css' />
        
      

        <link rel='stylesheet' id='electro-rtl-style-css'  href='/js_css/rtl.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='electro-rtl-style-v2-css'  href='/js_css/v2-rtl.min.css' type='text/css' media='all' />
        <script type='text/javascript' src='/js_css/jquery.js'></script>
        <script type='text/javascript' src='/js_css/jquery-migrate.min.js'></script>
        <script type='text/javascript' src='/js_css/jquery.themepunch.tools.min.js'></script>
        <script type='text/javascript' src='/js_css/jquery.themepunch.revolution.min.js'></script>

        <script type='text/javascript' src='/js_css/add-to-cart.min.js'></script>
        <script type='text/javascript' src='/js_css/woocommerce-add-to-cart.js'></script>



        <link rel='stylesheet' id='rs-plugin-settings-css'  href='<?= Url::to(['/site/color']) ?>' type='text/css' media='all' />



        <noscript>
        <style>.woocommerce-product-gallery{ opacity: 1 !important; }</style>
        </noscript>
        <meta name="generator" content="Powered by WPBakery Page Builder - drag and drop page builder for WordPress."/>

        <meta name="generator" content="Powered by Slider Revolution 5.4.7.1 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />

        <link rel="icon" href="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/backend/web/' . $sitesetting->fav ?>" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/backend/web/' . $sitesetting->fav ?>" />
        <meta name="msapplication-TileImage" content="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/backend/web/' . $sitesetting->fav ?>" />
        <script type="text/javascript">function setREVStartSize(e) {
                try {
                    e.c = jQuery(e.c);
                    var i = jQuery(window).width(), t = 9999, r = 0, n = 0, l = 0, f = 0, s = 0, h = 0;
                    if (e.responsiveLevels && (jQuery.each(e.responsiveLevels, function (e, f) {
                        f > i && (t = r = f, l = e), i > f && f > r && (r = f, n = e)
                    }), t > r && (l = n)), f = e.gridheight[l] || e.gridheight[0] || e.gridheight, s = e.gridwidth[l] || e.gridwidth[0] || e.gridwidth, h = i / s, h = h > 1 ? 1 : h, f = Math.round(h * f), "fullscreen" == e.sliderLayout) {
                        var u = (e.c.width(), jQuery(window).height());
                        if (void 0 != e.fullScreenOffsetContainer) {
                            var c = e.fullScreenOffsetContainer.split(",");
                            if (c)
                                jQuery.each(c, function (e, i) {
                                    u = jQuery(i).length > 0 ? u - jQuery(i).outerHeight(!0) : u
                                }), e.fullScreenOffset.split("%").length > 1 && void 0 != e.fullScreenOffset && e.fullScreenOffset.length > 0 ? u -= jQuery(window).height() * parseInt(e.fullScreenOffset, 0) / 100 : void 0 != e.fullScreenOffset && e.fullScreenOffset.length > 0 && (u -= parseInt(e.fullScreenOffset, 0))
                        }
                        f = u
                    } else
                        void 0 != e.minHeight && f < e.minHeight && (f = e.minHeight);
                    e.c.closest(".rev_slider_wrapper").css({height: f})
                } catch (d) {
                    console.log("Failure at Presize of Slider:" + d)
                }
            }
            ;
        </script>

        <noscript>
        <style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style>
        </noscript>
        <?php $this->head() ?>
    </head>
    <body class="rtl page-template page-template-template-homepage-v3 page-template-template-homepage-v3-php page page-id-2174 electro-compact wpb-js-composer js-comp-ver-5.4.7 vc_responsive">
        <?php $this->beginBody() ?>
        <div class="off-canvas-wrapper">
            <div id="page" class="hfeed site">

                <div class="top-bar hidden-lg-down">
                    <div class="container">
                        <ul id="menu-top-bar-left" class="nav nav-inline pull-left electro-animate-dropdown flip">
                            <li id="menu-item-3233" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3233"><a title="Welcome to Worldwide Electronics Store" href="#"><?= Post::findone(32)->body ?></a></li>
                        </ul>
                        <ul id="menu-top-bar-right" class="nav nav-inline pull-right electro-animate-dropdown flip">
                            <li id="menu-item-4105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4105"><a title="پیگری سفارشات" href="<?= Url::to(['/site/track_order']) ?>"><i class="ec ec-transport"></i>پیگیری سفارشات </a></li>
                            <?php if (Yii::$app->user->isGuest) { ?>
                                <li id="menu-item-4100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4100"><a title="ورود" href="<?= Url::to(['/site/login']) ?>" ><i class="ec ec-user"></i>ورود</a></li>
                                <li id="menu-item-4100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4100"><a title="" href="<?= Url::to(['/site/signup']) ?>" >ثبت نام</a></li>

                            <?php } else { ?>
                                <li id="menu-item-4100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4100"><a title="خروج" href="<?= Url::to(['/site/logout']) ?>" ><i class="ec ec-user"></i>خروج  <?= Yii::$app->user->identity->email ?></a></li>
                                <li id="menu-item-4100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4100"><a title="سفارشات" href="<?= Url::to(['/site/user_order_history']) ?>" >سفارش ها  </a></li>

                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!-- /.top-bar -->
                <header id="masthead" class="site-header header-v3 stick-this">
                    <div class="container hidden-lg-down">
                        <div class="masthead">
                            <div class="header-icons">


                                <div class="header-icon">
                                    <a href="<?= url::to(['/site/cart']) ?>" >
                                        <i class="ec ec-shopping-bag"></i>
                                        <span class="cart-items-count count header-icon-counter"><?= Post::arabic_w2e(ProductOrder::get_order_count()); ?></span>

                                    </a>

                                </div>
                            </div>
                            <div class="off-canvas-navigation-wrapper ">
                                <div class="off-canvas-navbar-toggle-buttons clearfix">
                                    <button class="navbar-toggler navbar-toggle-hamburger " type="button">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <button class="navbar-toggler navbar-toggle-close " type="button">
                                        <i class="ec ec-close-remove"></i>
                                    </button>
                                </div>






                                <div class="off-canvas-navigation" id="default-oc-header">
                                    <ul id="menu-all-departments-menu" class="nav nav-inline yamm">
                                        <li id="menu-item-4155" class="highlight menu-item menu-item-type-post_type menu-item-object-page menu-item-4155"><a title="خانه" href="/">خانه</a></li>

                                        <?php
                                        foreach ($array as $items) {

                                            if ($items->children) {
                                                ?>

                                                <li id="" class="yamm-tfw menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-3804 dropdown" data-id="<?= $items->id ?>">

                                                    <a title="" href="<?= get_item_link($items->id) ?>" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">
                                                        <?= get_item_name($items->id) ?>
                                                    </a>
                                                    <?php if ($items->children) { ?>
                                                        <ul role="menu" class=" dropdown-menu">
                                                            <?php if ($items->children) { ?>


                                                                <?php foreach ($items->children as $child) { ?>
                                                                    <li id="menu-item-4116" class="menu-item menu-item-type-post_type menu-item-object-static_block menu-item-4116" data-id="<?= $child->id ?>">

                                                                        <div class="yamm-content">

                                                                            <div class="vc_row wpb_row vc_row-fluid">
                                                                                <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                                    <div class="vc_column-inner ">
                                                                                        <div class="wpb_wrapper">
                                                                                            <div class="wpb_text_column wpb_content_element ">
                                                                                                <div class="wpb_wrapper">
                                                                                                    <ul>

                                                                                                        <li class="nav-title">
                                                                                                            <a href="<?= get_item_link($child->id) ?>">
                                                                                                                <?= get_item_name($child->id) ?>
                                                                                                            </a>
                                                                                                        </li>
                                                                                                        <?php if ($child->children) { ?>
                                                                                                            <?php foreach ($child->children as $child_3th) { ?>

                                                                                                                <li ><a href="<?= get_item_link($child_3th->id) ?>"><?= get_item_name($child_3th->id) ?></a></li>
                                                                                                            <?php } ?>
                                                                                                        <?php } ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php } ?>

                                                            <?php } ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }
                                            } else {
                                                ?>

                                                <li id="menu-item-4156" class="highlight menu-item menu-item-type-post_type menu-item-object-page menu-item-4156" >
                                                    <a title="" href="<?= get_item_link($items->id) ?>">
                                                        <?= get_item_name($items->id) ?>
                                                    </a>
                                                </li>          

                                                <?php
                                            }
                                        }
                                        ?>






                                    </ul>
                                </div>
                            </div>
                            <form class="navbar-search" method="get" action="<?= Url::to(['site/gserach']) ?>">
                                <label class="sr-only screen-reader-text" for="جستجو برای:"></label>
                                <div class="input-group">
                                    <div class="input-search-field">
                                        <input type="text" id="q" class="form-control search-field product-search-field" dir="rtl" value="" name="s" placeholder="جستجو" />
                                    </div>

                                    <div class="input-group-btn">
                                        <input type="hidden" id="search-param" name="post_type" value="product" />
                                        <button type="submit" class="btn btn-secondary"><i class="ec ec-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <!-- /.header-icons -->
                            <div class="header-logo-area">
                                <div class="header-site-branding">
                                    <img src="/backend/web/<?= $sitesetting->logo ?>" alt="" title=""> 
                                </div>
                            </div>
                        </div>



                        <div class="electro-navbar-primary electro-animate-dropdown">
                            <div class="container">
                                <ul id="menu-navbar-primary" class="nav navbar-nav yamm">
                                    <!--                                    ////////////////////////////////////////////////////////////-->

                                    <li id="menu-item-4101" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4123">
                                        <a title="خانه" href="/" >خانه</a>
                                    </li>







                                    <!--                                       /////////////////////////////////////////////////////////////////////////-->



                                    <?php
                                    foreach ($array as $items) {

                                        $mega = FALSE;
                                        if ($items->mega == "YES") {
                                            $mega = TRUE;
                                        }
                                        ?>



                                        <?php if (!$mega) { ?>
                                            <?php if ($items->children) { ?> 
                                                <li class="menu-item menu-item-type-post_type menu-item-
                                                    object-page menu-item-has-children current-menu-item current_page_item menu-item-4101 dropdown active" data-id="<?= $items->id ?>">

                                                    <a href="<?= get_item_link($items->id) ?>"




                                                       class="dropdown-toggle" 
                                                       aria-haspopup="true" data-hover="dropdown" aria-expanded="false">
                                                           <?= get_item_name($items->id) ?>

                                                    </a>
                                                    <?php if ($items->children) { ?>
                                                        <ul   role="menu" class=" dropdown-menu"><?php foreach ($items->children as $child) { ?>

                                                                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4104" data-id="<?= $child->id ?>" >

                                                                    <a href="<?= get_item_link($child->id) ?>" class=" dropdown-link" data-toggle="dropdown">
                                                                        <?= get_item_name($child->id) ?>
                                                                        <?php if ($child->children) { ?> 
                                                                            <i class="fa fa-angle-down"></i>
                                                                            <i class="sub-dropdown1  visible-sm visible-md visible-lg"></i>
                                                                            <i class="sub-dropdown visible-sm visible-md visible-lg"></i>
                                                                        <?php } ?>
                                                                    </a>



                                                                </li>

                                                            <?php } ?>

                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } else { ?>
                                                <li id="menu-item-4101" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4123">
                                                    <a title="خانه" href="<?= get_item_link($items->id) ?>" >

                                                        <?= get_item_name($items->id) ?>
                                                    </a>
                                                </li>

                                                <?php
                                            }
                                            // end of ifelse for having dropdown or not
                                            ?>
                                        <?php } else { ?>
                                            <li class=" mega_menu yamm-fw menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-has-children menu-item-4783 dropdown">
                                                <a href="<?= get_item_link($items->id) ?>" class="dropdown-toggle" aria-haspopup="true" data-hover="dropdown">
                                                    <?= get_item_name($items->id) ?>

                                                </a>

                                                <ul role="menu" class=" dropdown-menu">
                                                    <?php if ($items->children) { ?>


                                                        <?php foreach ($items->children as $child) { ?>

                                                            <li class="menu-item menu-item-type-post_type menu-item-object-static_block menu-item-4784">
                                                                <div class="yamm-content">
                                                                    <div class="vc_row wpb_row vc_row-fluid">
                                                                        <div class="wpb_column vc_column_container vc_col-sm-3">
                                                                            <div class="vc_column-inner ">
                                                                                <div class="wpb_wrapper">
                                                                                    <div  class="vc_wp_custommenu wpb_content_element">
                                                                                        <div class="widget widget_nav_menu">
                                                                                            <div class="menu-pages-menu-1-container">


                                                                                                <ul id="menu-pages-menu-1" class="menu menu_sub_mega">
                                                                                                    <li id="menu-item-3830" class="nav-title menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-3830"><a href='<?= get_item_link($child->id) ?>'><?= get_item_name($child->id) ?></a></li>
                                                                                                    <?php if ($child->children) { ?>
                                                                                                        <?php foreach ($child->children as $child_3th) { ?>

                                                                                                            <li class="list-unstyled li-sub-mega">
                                                                                                                <a href="<?= get_item_link($child_3th->id) ?>"><?= get_item_name($child_3th->id) ?></a>
                                                                                                            </li>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </li>
                                                        <?php } ?>

                                                    <?php } ?>
                                                </ul>


                                            </li>


                                        <?php } ?>



                                    <?php } ?>  









                                    <!--                                    ///////////////////////////////////////////////////////////////////   
                                    -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="handheld-header-wrap container hidden-xl-up">
                        <div class="handheld-header-v2 ">
                            <div class="off-canvas-navigation-wrapper ">
                                <div class="off-canvas-navbar-toggle-buttons clearfix"> 
                                    <button class="navbar-toggler navbar-toggle-hamburger " type="button">
                                        <span class="navbar-toggler-icon"></span> </button>
                                    <button class="navbar-toggler navbar-toggle-close " type="button"> <i class="ec ec-close-remove"></i> </button>
                                </div>
                                <div class="off-canvas-navigation" id="default-oc-header">

                                    <div class="off-canvas-navigation" id="default-oc-header">
                                        <ul id="menu-all-departments-menu" class="nav nav-inline yamm">
                                            <li id="menu-item-4155" class="highlight menu-item menu-item-type-post_type menu-item-object-page menu-item-4155"><a title="خانه" href="/">خانه</a></li>

                                            <?php
                                            foreach ($array as $items) {

                                                if ($items->children) {
                                                    ?>

                                                    <li id="" class="yamm-tfw menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-3804 dropdown" data-id="<?= $items->id ?>">

                                                        <a title="" href="<?= get_item_link($items->id) ?>" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">
                                                            <?= get_item_name($items->id) ?>
                                                        </a>
                                                        <?php if ($items->children) { ?>
                                                            <ul role="menu" class=" dropdown-menu">
                                                                <?php if ($items->children) { ?>


                                                                    <?php foreach ($items->children as $child) { ?>
                                                                        <li id="menu-item-4116" class="menu-item menu-item-type-post_type menu-item-object-static_block menu-item-4116" data-id="<?= $child->id ?>">

                                                                            <div class="yamm-content">

                                                                                <div class="vc_row wpb_row vc_row-fluid">
                                                                                    <div class="wpb_column vc_column_container vc_col-sm-6">
                                                                                        <div class="vc_column-inner ">
                                                                                            <div class="wpb_wrapper">
                                                                                                <div class="wpb_text_column wpb_content_element ">
                                                                                                    <div class="wpb_wrapper">
                                                                                                        <ul>

                                                                                                            <li class="nav-title">
                                                                                                                <a href="<?= get_item_link($child->id) ?>">
                                                                                                                    <?= get_item_name($child->id) ?>
                                                                                                                </a>
                                                                                                            </li>
                                                                                                            <?php if ($child->children) { ?>
                                                                                                                <?php foreach ($child->children as $child_3th) { ?>

                                                                                                                    <li ><a href="<?= get_item_link($child_3th->id) ?>"><?= get_item_name($child_3th->id) ?></a></li>
                                                                                                                <?php } ?>
                                                                                                            <?php } ?>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    <?php } ?>

                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>

                                                    <li id="menu-item-4156" class="highlight menu-item menu-item-type-post_type menu-item-object-page menu-item-4156" >
                                                        <a title="" href="<?= get_item_link($items->id) ?>">
                                                            <?= get_item_name($items->id) ?>
                                                        </a>
                                                    </li>          

                                                    <?php
                                                }
                                            }
                                            ?>


                                        </ul>
                                    </div>


                                </div>





                            </div>
                            <div class="header-logo">
                                <a href="/" class="header-logo-link">
                                    <img src="<?=  '/backend/web/' . $sitesetting->logo ?>" >
                                </a>
                            </div>
                            <div class="handheld-header-links">
                                <ul class="columns-3">
                                    <li class="search">
                                        <a href="">Search</a>
                                        <div class="site-search">
                                            <div class="widget woocommerce widget_product_search">
                                                <form role="search" method="get" class="woocommerce-product-search" action="/site/gsearch"> 
                                                    <label class="screen-reader-text" for="woocommerce-product-search-field-0">
                                                        جستجو...</label> 
                                                    <input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="جستجو..." value="" name="s"> <button type="submit" value="Search">Search</button> <input type="hidden" name="post_type" value="product"></form>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="my-account">
                                         <?php if (Yii::$app->user->isGuest) { ?>
                                        <a href="<?= url::to(['/site/login']) ?>">My Account</a>
                                         <?php }else{ ?>
                                          <a href="<?= url::to(['/site/logout']) ?>">My Account</a>
                                         <?php } ?>
                                    </li>
                                    <li class="cart"> <a class="footer-cart-contents" href="<?= url::to(['/site/card']) ?>" title="View your shopping cart"> 
                                            <span class="cart-items-count count header-icon-counter">
                                                <?= Post::arabic_w2e(ProductOrder::get_order_count()); ?>
                                            </span> 
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </header>
                <!-- #masthead -->


                <?= Alert::widget() ?>
                <?= $content ?>


                <section class="brands-carousel">
                    <h2 class="sr-only">برندها</h2>
                    <div class="container">
                        <div id="owl-brands" class="owl-brands owl-carousel electro-owl-carousel owl-outer-nav" data-ride="owl-carousel" data-carousel-selector="self" data-carousel-options="{&quot;items&quot;:5,&quot;navRewind&quot;:true,&quot;autoplayHoverPause&quot;:true,&quot;nav&quot;:true,&quot;stagePadding&quot;:1,&quot;dots&quot;:false,&quot;rtl&quot;:true,&quot;navText&quot;:[&quot;&lt;i class=\&quot;fa fa-chevron-right\&quot;&gt;&lt;\/i&gt;&quot;,&quot;&lt;i class=\&quot;fa fa-chevron-left\&quot;&gt;&lt;\/i&gt;&quot;],&quot;touchDrag&quot;:false,&quot;responsive&quot;:{&quot;0&quot;:{&quot;items&quot;:1},&quot;480&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:2},&quot;992&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:5}}}">




                            <?php
                            $postS = \common\models\PostHasCategory::find()->innerJoinWith('post')->where('category_id=11')->all();
                            foreach ($postS as $post) {
                                ?>
                                <div class="item">
                                    <figure>
                                        <figcaption class="text-overlay">
                                            <div class="info">
                                                <h4>fgdfgxsdfg</h4>
                                            </div>
                                            <!-- /.info -->
                                        </figcaption>
                                        <img src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/backend/web/' . $post->post->thumb_nail ?>" alt="<?= strip_tags($post->post->title) ?>" width="200" height="60" class="img-responsive desaturate">
                                    </figure>

                                </div>
                                <!-- /.item -->
                            <?php } ?>

                        </div>
                        <!-- /.owl-carousel -->
                    </div>
                </section>


                <footer id="colophon" class="site-footer footer-v2">
                    <div class="desktop-footer container">


                        <div class="footer-bottom-widgets">
                            <div class="container">
                                <div class="footer-bottom-widgets-inner">
                                    <div class="footer-contact">
                                      


                                        <div class="footer-call-us">
                                            <div class="media">
                                                <span class="media-left call-us-icon media-middle"><i class="ec ec-support"></i></span>
                                                <div class="media-body">
                                                    <?= Post::findone(16)->body ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-address">
                                            <strong class="footer-address-title">آدرس</strong>
                                            <address><?= $sitesetting->address ?></address>
                                        </div>
                                        <div class="footer-social-icons">
                                            <ul class="social-icons list-unstyled">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="footer-bottom-widgets-menu">
                                        <div class="footer-bottom-widgets-menu-inner">
                                            <div class="columns">
                                                <aside id="nav_menu-1" class="widget clearfix widget_nav_menu">
                                                    <div class="body">
                                                       <img src="https://trustseal.enamad.ir/logo.aspx?id=97186&amp;p=MhwGKvDInkE2tSVr" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=97186&amp;p=MhwGKvDInkE2tSVr&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)" style="cursor:pointer" id="MhwGKvDInkE2tSVr">

                                                    </div>
                                                </aside>
                                            </div>
                                            <div class="columns">
                                                <aside id="nav_menu-2" class="widget clearfix widget_nav_menu">
                                                    <div class="body">
                                                        <?= Post::findone(14)->body ?>
                                                    </div>
                                                </aside>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="copyright-bar">
                            <div class="container">
                                <div class="copyright">&copy; <a href="http://forpido.com">SIZE.IR</a> - All Rights Reserved<?= date('Y') ?></div>

                                <div class="payment">
                                    <div class="footer-social-icons">
                                        <ul class="social-icons list-unstyled">
                                            <li><a class="fa fa-facebook" target="_blank" href="<?= $sitesetting->facebook ?>"></a></li>
                                            <li><a class="fa fa-whatsapp mobile" target="_blank" href="<?= $sitesetting->whatsapp ?>"></a></li>
                                            <li><a class="fa fa-whatsapp desktop" target="_blank" href="<?= $sitesetting->whatsapp ?>"></a></li>
                                            
                                           
                                            <li><a class="fa fa-instagram" target="_blank" href="<?= $sitesetting->instagram ?>"></a></li>
                                            <li><a class="fa fa-twitter" target="_blank" href="<?= $sitesetting->twitter ?>"></a></li>
                                            <li><a class="fa fa-telegram" target="_blank" href="<?= $sitesetting->telegram ?>"></a></li>




                                        </ul>
                                    </div>
                                    <!-- /.payment-methods -->
                                </div>
                            </div>
                        </div>
                    </div>

                </footer>
                <!-- #colophon -->
            </div>
            <!-- #page -->

            <script type="text/javascript">
                function revslider_showDoubleJqueryError(sliderID) {
                    var errorMessage = "Revolution Slider Error: You have some jquery.js library include that comes after the revolution files js include.";
                    errorMessage += "<br> This includes make eliminates the revolution slider libraries, and make it not work.";
                    errorMessage += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Slider Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";
                    errorMessage += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.";
                    errorMessage = "<span style='font-size:16px;color:#BC0C06;'>" + errorMessage + "</span>";
                    jQuery(sliderID).show().html(errorMessage);
                }
            </script>
            <link rel='stylesheet' id='js_composer_front-css'  href='/js_css/js_composer.min.css' type='text/css' media='all' />
            <script type='text/javascript'>
                /* <![CDATA[ */
                var wpcf7 = {"apiSettings": {"root": "https:\/\/demo2.madrasthemes.com\/electro\/wp-json\/contact-form-7\/v1", "namespace": "contact-form-7\/v1"}, "recaptcha": {"messages": {"empty": "Please verify that you are not a robot."}}, "cached": "1"};
                /* ]]> */
            </script>
            <script type='text/javascript' src='/js_css/scripts.js'></script>
            <script type='text/javascript' src='/js_css/jquery.blockUI.min.js'></script>  
            <script type='text/javascript' src='/js_css/js.cookie.min.js'></script>
            <script type='text/javascript'>
                /* <![CDATA[ */
                var woocommerce_params = {"ajax_url": "\/electro\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/electro\/?wc-ajax=%%endpoint%%"};
                /* ]]> */
            </script>
            <script type='text/javascript' src='/js_css/woocommerce.min.js'></script>
            <script type='text/javascript'>
                /* <![CDATA[ */
                var wc_cart_fragments_params = {"ajax_url": "\/electro\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/electro\/?wc-ajax=%%endpoint%%", "cart_hash_key": "wc_cart_hash_b907adfd7121301f62dfd9dc9a37560b", "fragment_name": "wc_fragments_b907adfd7121301f62dfd9dc9a37560b"};
                /* ]]> */
            </script>

            <script type='text/javascript'>
                /* <![CDATA[ */
                var yith_woocompare = {"ajaxurl": "\/electro\/?wc-ajax=%%endpoint%%", "actionadd": "yith-woocompare-add-product", "actionremove": "yith-woocompare-remove-product", "actionview": "yith-woocompare-view-table", "actionreload": "yith-woocompare-reload-product", "added_label": "Added", "table_title": "Product Comparison", "auto_open": "yes", "loader": "https:\/\/demo2.madrasthemes.com\/electro\/wp-content\/plugins\/yith-woocommerce-compare\/assets\/images\/loader.gif", "button_text": "Compare", "cookie_name": "yith_woocompare_list", "close_label": "Close"};
                /* ]]> */
            </script>
            <script type='text/javascript' src='/js_css/woocompare.min.js'></script>
            <script type='text/javascript' src='/js_css/jquery.colorbox-min.js'></script>
            <script type='text/javascript' src='/js_css/jquery.prettyPhoto.min.js'></script>
            <script type='text/javascript' src='/js_css/jquery.selectBox.min.js'></script>
            <script type='text/javascript'>
                /* <![CDATA[ */
                var yith_wcwl_l10n = {"ajax_url": "\/electro\/wp-admin\/admin-ajax.php", "redirect_to_cart": "no", "multi_wishlist": "", "hide_add_button": "1", "is_user_logged_in": "", "ajax_loader_url": "https:\/\/demo2.madrasthemes.com\/electro\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader.gif", "remove_from_wishlist_after_add_to_cart": "yes", "labels": {"cookie_disabled": "We are sorry, but this feature is available only if cookies are enabled on your browser.", "added_to_cart_message": "<div class=\"woocommerce-message\">Product correctly added to cart<\/div>"}, "actions": {"add_to_wishlist_action": "add_to_wishlist", "remove_from_wishlist_action": "remove_from_wishlist", "move_to_another_wishlist_action": "move_to_another_wishlsit", "reload_wishlist_and_adding_elem_action": "reload_wishlist_and_adding_elem"}};
                /* ]]> */
            </script>
            <script type='text/javascript' src='/js_css/jquery.yith-wcwl.js'></script>
            <script type='text/javascript' src='/js_css/tether.min.js'></script>
            <script type='text/javascript' src='/js_css/bootstrap.min.js'></script>
            <script type='text/javascript' src='/js_css/jquery.waypoints.min.js'></script>
            <script type='text/javascript' src='/js_css/waypoints-sticky.min.js'></script>
            <script type='text/javascript' src='/js_css/jquery.easing.min.js'></script>
            <script type='text/javascript' src='/js_css/scrollup.min.js'></script>
            <script type='text/javascript' src='/js_css/bootstrap-hover-dropdown.min.js'></script>
            <script type='text/javascript'>
                /* <![CDATA[ */
                var electro_options = {"rtl": "1",   "enable_sticky_header": "1", };
                /* ]]> */
            </script>
            
            
            <script type='text/javascript' src='/js_css/smoothproducts.min.js'></script>
            
            <script type='text/javascript' src='/js_css/electro.min.js'></script>
            <script type='text/javascript' src='/js_css/owl.carousel.min.js'></script>
            <script type='text/javascript' src='/js_css/pace.min.js'></script>
            <script type='text/javascript' src='/js_css/js_composer_front.min.js'></script>
            <script type="text/javascript" src="/js_css/revolution.extension.slideanims.min.js"></script>
            <script type="text/javascript" src="/js_css/revolution.extension.actions.min.js"></script>
            <script type="text/javascript" src="/js_css/revolution.extension.layeranimation.min.js"></script>
            <script type="text/javascript" src="/js_css/revolution.extension.navigation.min.js"></script>
          
            <script type='text/javascript' src='/js.js?=<?= rand(1, 200) ?>'></script>
            
         
            

         
            <?php $this->endBody() ?>
            
            
            
            
    </body>
</html>
<?php $this->endPage() ?>
