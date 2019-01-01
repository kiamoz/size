<?php

use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="theme/images/icons/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="theme/images/icons/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="theme/images/icons/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="theme/images/icons/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="icon.png">



        <link rel="stylesheet" type="text/css" href="theme/bootstrap/css/bootstrap.css">


        <!-- HELPERS -->

        <link rel="stylesheet" type="text/css" href="theme/helpers/animate.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/backgrounds.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/boilerplate.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/border-radius.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/grid.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/page-transitions.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/spacing.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/typography.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/utils.css">
        <link rel="stylesheet" type="text/css" href="theme/helpers/colors.css">

        <!-- ELEMENTS -->

        <link rel="stylesheet" type="text/css" href="theme/elements/badges.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/buttons.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/content-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/dashboard-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/forms.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/images.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/info-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/invoice.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/loading-indicators.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/menus.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/panel-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/response-messages.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/responsive-tables.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/ribbon.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/social-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/tables.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/tile-box.css">
        <link rel="stylesheet" type="text/css" href="theme/elements/timeline.css">



        <!-- ICONS -->

        <link rel="stylesheet" type="text/css" href="theme/icons/fontawesome/fontawesome.css">
        <link rel="stylesheet" type="text/css" href="theme/icons/linecons/linecons.css">
        <link rel="stylesheet" type="text/css" href="theme/icons/spinnericon/spinnericon.css">


        <!-- WIDGETS -->

        <link rel="stylesheet" type="text/css" href="theme/widgets/accordion-ui/accordion.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/calendar/calendar.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/carousel/carousel.css">

        <link rel="stylesheet" type="text/css" href="theme/widgets/charts/justgage/justgage.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/charts/morris/morris.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/charts/piegage/piegage.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/charts/xcharts/xcharts.css">

        <link rel="stylesheet" type="text/css" href="theme/widgets/chosen/chosen.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/colorpicker/colorpicker.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/datatable/datatable.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/datepicker/datepicker.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/datepicker-ui/datepicker.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/dialog/dialog.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/dropdown/dropdown.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/dropzone/dropzone.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/file-input/fileinput.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/input-switch/inputswitch.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/input-switch/inputswitch-alt.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/ionrangeslider/ionrangeslider.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/jcrop/jcrop.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/jgrowl-notifications/jgrowl.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/loading-bar/loadingbar.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/maps/vector-maps/vectormaps.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/markdown/markdown.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/modal/modal.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/multi-select/multiselect.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/multi-upload/fileupload.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/nestable/nestable.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/noty-notifications/noty.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/popover/popover.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/pretty-photo/prettyphoto.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/progressbar/progressbar.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/range-slider/rangeslider.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/slidebars/slidebars.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/slider-ui/slider.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/summernote-wysiwyg/summernote-wysiwyg.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/tabs-ui/tabs.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/theme-switcher/themeswitcher.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/timepicker/timepicker.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/tocify/tocify.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/tooltip/tooltip.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/touchspin/touchspin.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/uniform/uniform.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/wizard/wizard.css">
        <link rel="stylesheet" type="text/css" href="theme/widgets/xeditable/xeditable.css">

        <!-- SNIPPETS -->

        <link rel="stylesheet" type="text/css" href="theme/snippets/chat.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/files-box.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/login-box.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/notification-box.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/progress-box.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/todo.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/user-profile.css">
        <link rel="stylesheet" type="text/css" href="theme/snippets/mobile-navigation.css">

        <!-- APPLICATIONS -->

        <link rel="stylesheet" type="text/css" href="theme/applications/mailbox.css">

        <!-- Admin theme -->

        <link rel="stylesheet" type="text/css" href="theme/themes/admin/layout.css">
        <link rel="stylesheet" type="text/css" href="theme/themes/admin/color-schemes/default.css">

        <!-- Components theme -->

        <link rel="stylesheet" type="text/css" href="theme/themes/components/default.css">
        <link rel="stylesheet" type="text/css" href="theme/themes/components/border-radius.css">

        <!-- Admin responsive -->




        <!-- JS Core -->

        <script type="text/javascript" src="theme/js-core/jquery-core.js"></script>
        <script type="text/javascript" src="theme/js-core/jquery-ui-core.js"></script>
        <script type="text/javascript" src="theme/js-core/jquery-ui-widget.js"></script>
        <script type="text/javascript" src="theme/js-core/jquery-ui-mouse.js"></script>
        <script type="text/javascript" src="theme/js-core/jquery-ui-position.js"></script>
        <!--<script type="text/javascript" src="theme/js-core/transition.js"></script>-->
        <script type="text/javascript" src="theme/js-core/modernizr.js"></script>
        <script type="text/javascript" src="theme/js-core/jquery-cookie.js"></script>

        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">


        <script type="text/javascript">
            $(window).load(function () {
                setTimeout(function () {
                    $('#loading').fadeOut(400, "linear");
                }, 300);
            });
        </script>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}

            #page-sidebar{
                float: right !important;
                margin-left: -100% !important;
                margin-right: 0 !important;
            }
            #header-logo ,  #page-sidebar li a .glyph-icon, #page-sidebar li ul li a:before, #page-sidebar li a .glyph-icon{
                float:  right !important;
            }
            #page-sidebar li a.sf-with-ul:after{
                left: 5px !important;
                right: 0px !important;
                transform: rotate(180deg);
            }
            #sidebar-menu > li > a , .sidebar-submenu ul li a{

                text-align: right;
            }
            #header-nav-left {
                float: right !important;

            }
            #header-nav-right {
                float: left !important;

            }

            @media screen and (min-width: 768px) 
            {
                #page-content{
                    margin-right: 260px !important;
                    margin-left: 0px !important;
                }
            }
            
            
            
/******* table RTL  by kiamoz  ***********/           

table,th,td{
    direction: rtl !important;
    
}

th,td{
   text-align: right !important;
}
            
/******* table RTL  by kiamoz  ***********/          
            
            
            
/******* select2 RTL  by kiamoz  ***********/
ul#select2-user-tahsilat-results,.span#select2-user-tahsilat-container {
    text-align: right;
}
span.select2-selection__clear {
    left: 13px;
    right: unset !important;
    position: absolute;
}
.select2-selection span ,.select2-results__options li,.select2-search__field{
    font-family: tahoma;
}
.select2-container{
    text-align: right;
}
.select2-container .select2-search--inline {
    float: right;
}
li.select2-selection__choice {
    direction: rtl;
}
/******* select2 RTL  by kiamoz  ***********/

            
            
            

        </style>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
    <body>
        <div id="sb-site">





            <div id="page-wrapper">
                <div id="page-header" class="bg-gradient-9">
                    <div id="mobile-navigation">
                        <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
                        <a href="index.html" class="logo-content-small" title="MonarchUI"></a>
                    </div>
                    <div id="header-logo" class="logo-bg">
                        <a href="https://avishost.com/" class="" title="Avis Product ">

                            <img src="we-are-avis.png" width="100">
                        </a>

                        <a id="close-sidebar" href="#" title="Close sidebar">
                            <i class="glyph-icon icon-angle-left"></i>
                        </a>
                    </div>
                    <div id="header-nav-left">
                        <div class="user-account-btn dropdown">
                            <a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown">
                                <img width="28" src="admin.png" alt="Profile image">
                                <span><?php echo Yii::$app->user->identity->username; ?></span>
                                <i class="glyph-icon icon-angle-down"></i>
                            </a>
                            <div class="dropdown-menu float-left">
                                <div class="box-sm">
                                    <div class="login-box clearfix">
                                        <div class="user-img">

                                            <img src="admin.png" alt="">
                                        </div>
                                        <div class="user-info">
                                            <span>

                                            </span>
                                            <a href="<?php echo Url::to(['site/editprofile', 'id' => Yii::$app->user->identity->id]) ?>" title="ویرایش اطلاعات">ویرایش اطلاعات</a>

                                        </div>
                                    </div>
                                    <div class="divider"></div>

                                    <div class="pad5A button-pane button-pane-alt text-center">
                                        <a href="<?php echo Url::to(['site/logout']) ?>" class="btn display-block font-normal btn-danger">
                                            <i class="glyph-icon icon-power-off"></i>
                                            خروج
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- #header-nav-left -->

                    <!-- #header-nav-right -->

                </div>
                <div id="page-sidebar">
                    <div class="scroll-sidebar">


                        <ul id="sidebar-menu">


                            <li class="divider"></li>

                            <li class="header"><span>منو</span></li>
                            <li>
                                <a href="#" title="تنظیمات سایت ">
                                    <i class="glyph-icon tooltip-button icon-edit"></i>
                                    <span>تنظیمات سایت </span>
                                </a>
                                <div class="sidebar-submenu">

                                    <ul>
                                        <li><a href="<?php echo Url::to(['/site/menu']) ?>" title="مدیریت منو"><span>مدیریت منو </span></a></li>
                                      
                                        <li><a href="<?php echo Url::to(['/sitesetting']) ?>" title="مدیریت تنظیمات"><span>مدیریت تنظیمات </span></a></li>
                                        <li><a href="<?php echo Url::to(['post/index_site_content']) ?>" title="مدیریت محتوای صفحه اصلی"><span>مدیریت محتوای صفحه اصلی </span></a></li>


                                        <li><a href="<?= Url::to(['site/clear']) ?>" title=""><span>Clear Site Cache</span></a></li>

                                    </ul>  

                                </div><!-- .sidebar-submenu -->
                            </li>
                            <li>
                                <a href="#" title="پست">
                                    <i class="glyph-icon tooltip-button icon-file-word-o"></i>
                                    <span>پست</span>
                                </a>
                                <div class="sidebar-submenu">

                                    <ul>
                                        <li><a href="<?php echo Url::to(['/post']) ?>" title="مدیریت  پست ها"><span>مدیریت  پست ها</span></a></li>

                                        <li><a href="<?php echo Url::to(['/category']) ?>" title="مدیریت  دسته بندی"><span>مدیریت دسته بندی</span></a></li>

                                        <li><a href="<?php echo Url::to(['/tag']) ?>" title="مدیریت  تگ"><span>مدیریت تگ ها</span></a></li>

                    
                                    </ul>     

                                </div><!-- .sidebar-submenu -->
                            </li>


<li class="sfHover">
                                <a href="#" title="Widgets" >
                                    <i class="glyph-icon icon-bolt"></i>
                                    <span>محصولات</span>
                                </a>
                                <div class="sidebar-submenu">

                                    <ul>


                                    <li><a href="<?= Url::to(['/product']) ?>" title=""><span> محصولات</span></a></li>
                                    <li><a href="<?= Url::to(['/product-category/index']) ?>" title=""><span>مدیریت دسته بندی</span></a></li>
                                    <li><a href="<?= Url::to(['/att-group']) ?>" title=""><span>مدیریت گروه بندی ویژگی ها</span></a></li>
                                    <li><a class="sfActive" href="<?= Url::to(['/att']) ?>" title=""><span>مدیریت ویژگی ها</span></a></li>
                                   
                                   
                               
                                    </ul>

                                </div><!-- .sidebar-submenu -->
                            </li>
                            
                            <li>
                            <a href="#" title="Forms UI">
                                <i class="glyph-icon icon-user"></i> 
                                <span> حمل و نقل</span>
                            </a>
                            <div class="sidebar-submenu">

                                <ul>
                                    <li><a href="<?= Url::to(['/state']) ?>" title=""><span>مدیریت استان ها </span></a></li>
                                    <li><a href="<?= Url::to(['/city']) ?>" title=""><span>مدیریت شهر ها</span></a></li>
                                 
                                    <li><a href="<?= Url::to(['/shipping_method']) ?>" title=""><span>مدیریت روش های ارسال</span></a></li>
                                        

                                </ul>


                            </div><!-- .sidebar-submenu -->
                        </li>
            <li><a href="<?= Url::to(['/order']) ?>" title="مدیریت سفارشات"> <span>مدیریت سفارشات سایت</span></a></li>
                           
     <li><a href="<?= Url::to(['/payment-method']) ?>" title="مدیریت سفارشات"> <span>روش های پرداخت</span></a></li>
                           




                            <?php
                            
                            if(Yii::$app->user->identity->level_id==10) {
                                ?>
                            
                                <li>
                                    <a href="#" title="کاربران">
                                        <i class="glyph-icon tooltip-button icon-users"></i>
                                        <span>کاربران</span>
                                    </a>
                                    <div class="sidebar-submenu">

                                        <ul>
                                            <li><a href="<?php echo Url::to(['/user']) ?>" title="مدیریت کاربران"><span>مدیریت کاربران</span></a></li>

                                        </ul>

                                    </div><!-- .sidebar-submenu -->
                                </li>


                            <?php } ?>
                        </ul><!-- #sidebar-menu -->


                    </div>
                </div>
                <div id="page-content-wrapper">
                    <div id="page-content">

                        <div class="container">
                            <?= Alert::widget() ?>

                            <?= $content ?>



                        </div>



                    </div>
                </div>
            </div>

        </div>




        <script type="text/javascript" src="theme/widgets/charts/sparklines/sparklines.js"></script>
        <script type="text/javascript" src="theme/widgets/charts/sparklines/sparklines-demo.js"></script>

        <script type="text/javascript" src="theme/tether/js/tether.js"></script>
        <script type="text/javascript" src="theme/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="theme/widgets/progressbar/progressbar.js"></script>
        <script type="text/javascript" src="theme/widgets/superclick/superclick.js"></script>
        <script type="text/javascript" src="theme/widgets/input-switch/inputswitch-alt.js"></script>
        <script type="text/javascript" src="theme/widgets/slimscroll/slimscroll.js"></script>
        <script type="text/javascript" src="theme/widgets/slidebars/slidebars.js"></script>
        <script type="text/javascript" src="theme/widgets/slidebars/slidebars-demo.js"></script>
        <script type="text/javascript" src="theme/widgets/charts/piegage/piegage.js"></script>
        <script type="text/javascript" src="theme/widgets/charts/piegage/piegage-demo.js"></script>
        <script type="text/javascript" src="theme/widgets/screenfull/screenfull.js"></script>
        <script type="text/javascript" src="theme/widgets/content-box/contentbox.js"></script>
        <script type="text/javascript" src="theme/widgets/overlay/overlay.js"></script>
        <script type="text/javascript" src="theme/js-init/widgets-init.js"></script>
        <script type="text/javascript" src="theme/themes/admin/layout.js"></script>
        <script type="text/javascript" src="theme/widgets/theme-switcher/themeswitcher.js"></script>

        <script src="jquery.nestable.js"></script>
          <script type="text/javascript" src="js.js"></script>

        <!-- datepicker-->


        <!-- datepicker-->




        <script>

                $('.removex').click(function () {

                    remove_from_gallery($(this).attr('title'));
                    $(this).parent().parent().parent().parent().hide();
                });

                function remove_from_gallery(content) {
                    var gall = $('#movie-gallery').val();
                    gall = gall.replace(content, '');
                    $('#movie-gallery').val(gall);
                }
        </script>
        <script>

            ;

        </script>
        <script src="jquery.maskMoney.min.js"></script>
        <script src="variant.js?ver=<?= rand(1, 200) ?>"></script>
        
        <script>
            $('.maskm').maskMoney({precision: '0'});
        </script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
