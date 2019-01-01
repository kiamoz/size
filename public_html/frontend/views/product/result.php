<?php
   use yii\helpers\Url;
   use common\models\Product;
   use yii\data\Pagination;
   use yii\widgets\LinkPager;
   use yii\bootstrap\ActiveForm;
   use yii\helpers\Html;
   $site_base = dirname(dirname(dirname(dirname(__FILE__))));
   $tt=  \common\models\ProductCategory::findOne($_GET['id']);
   $this->title =$tt->name ;
   ?> 
<style> 
   body .sidebar .sidebar-block {
   padding: 10px 15px 25px;
   }
   .redbtn{
        background: #E0493D !important;
            color: #FFF !important;
    }
   .stage {
   transform: scale(0.4) !important;
   margin: 5% -16% !important;
   position: relative;
   right: 24px;
   }
   .col-info {
   position: relative;
   top: -223px;
   }
   .none-book{
   top: 0 !important;
   }
   h4.title {
   min-height: 55px;
   } 
   
</style>
<div class="page-container" id="PageContainer">
   <main class="main-content" id="MainContent" role="main">
      <section class="collection-heading heading-content ">
         <div class="container">
            <div class="row">
               <div class="collection-wrapper">
                  <h1 class="collection-title"><span>نتایج جستجو در : <?= common\models\ProductCategory::breadcrumb($_POST['cat_id']); ?></span></h1>
               </div>
            </div>
         </div>
      </section>
      <section class="list-collection-content">
         <div class="list-collections-wrapper ">
            <div class="container">
               <div class="row">
                  <div class="products-wrapper">
                     <div class="products-wrapper-inner">
                        <div class="products masonry col-md-9">
                           <?php foreach ($cate as $catt){ ?>
                           <div class="col-sm-3 col-xs-12">
                              <div class="product ">
                                 <!-- Begin product image -->
                                 <?php 
                                    $idd= $catt->product->id;
                                    $isbook=FALSE;
                                    $pc=Product::getproductCats($idd) ;
                                    foreach ($pc as $pcc){
                                    
                                    if($pcc==275){ 
                                       
                                       $isbook=TRUE;
                                       break;
                                    
                                    }
                                    
                                    if(common\models\ProductCategory::get_root_id($pcc)==275){ 
                                         $isbook=TRUE;
                                         break;
                                    }
                                    
                                        // echo $isbook .'***'; 
                                    }?>                                                                                                      
                                 <?php if($isbook){ 
                                    ?> 
                                 <a href="<?php echo  Url::to(['product/view','id'=>$catt->product->id]) ?>">
                                    <div  class="stage">
                                       <div class="book_group">
                                          <div class="book_back"></div>
                                          <div class="book_front"  style="background-image: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.25) 25%, rgba(0, 0, 0, 0.15) 50%, rgba(255, 255, 255, 0) 100%), url(<?PHP  echo common\models\Product::resize_img($site_base.'/backend/web/'.$catt->product->thumbnail, 332,450, "_".$catt->product->id); ?>" alt="<?php echo $catt->product->name  ?>);">
                                             <div class="book_front_trim">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </a>
                                 <?php } else { ?> 
                                 <a href="<?= Url::to(['product/view','id'=>$catt->product->id]) ?>">
                                 <img src="<?PHP  echo common\models\Product::resize_img($site_base.'/backend/web/'.$catt->product->thumbnail, 332,350, "_".$catt->product->id); ?>">
                                 </a>
                                 <?php }?>
                                 <div class="clearfix"> </div>
                                 <!-- End product image -->
                                 <!-- Begin product description -->
                                 <div class="col-info <?php if(!$isbook){ echo "none-book";} ?>">
                                    <h4 class="title"><?php echo $catt->product->name  ?></h4>
                                    <input type="hidden" value="<?= $catt->product->id ?>" class="product_id" />
                                    <input type="hidden" value="1" class="qty_card" />
                                    
                                    
                                    
                                    <?php if($catt->product->status == 1){ ?>
                                    <del class="price_compare add_to_card_ajax">
                                    <span class="money ezafe quick_shop" data-currency-usd=""  data-target="#quick-shop-modal" data-toggle="modal" ><i class="fa fa-shopping-cart" aria-hidden="true"></i>اضافه به سبد </span></del>
                                    
                                    <del class="price_compare"> <span class="money ok" style=" display: none" data-currency-usd="">به سبد اضافه شد</span></del>
                                    <?php }elseif ($catt->product->status == -1) { ?>
                                    
                                                                                                                                                                            <del class="price_compare ">
                                    <span class="money ezafe quick_shop redbtn" data-currency-usd=""  data-target="#quick-shop-modal" data-toggle="modal" >موجود نیست ... </span></del>
                                                                                                                                    <?php } ?>   
                                    <span class="pad20"></span>
                                    <span class="price">
                                    <?php $lastp = \common\models\Product::get_last_price($catt->product->id); ?>
                                    <?php if($lastp){echo "
                                       <span class='amount'>".\common\models\Post::arabic_w2e(number_format($lastp))."ریال</span>
                                       
                                       ";}?>
                                    </span>
                                 </div>
                                 <!-- End product description -->
                              </div>
                           </div>
                           <?php }?>
                        </div>
                          <div class="collection-leftsidebar sidebar col-sm-3">
                           <?php $form = ActiveForm::begin(['action'=>'/product/result']); ?>
                          <div class="nav-search">
                                       
                                       <input type="hidden" name="type" value="product">
                                       <input type="text" name="search" class="search_box" placeholder="جستجو در این دسته بندی... " value="">
                                       <button class="search_submit ss" type="submit">
                                          <svg aria-hidden="true" role="presentation" class="icon icon-search" viewBox="0 0 37 40">
                                             <path d="M35.6 36l-9.8-9.8c4.1-5.4 3.6-13.2-1.3-18.1-5.4-5.4-14.2-5.4-19.7 0-5.4 5.4-5.4 14.2 0 19.7 2.6 2.6 6.1 4.1 9.8 4.1 3 0 5.9-1 8.3-2.8l9.8 9.8c.4.4.9.6 1.4.6s1-.2 1.4-.6c.9-.9.9-2.1.1-2.9zm-20.9-8.2c-2.6 0-5.1-1-7-2.9-3.9-3.9-3.9-10.1 0-14C9.6 9 12.2 8 14.7 8s5.1 1 7 2.9c3.9 3.9 3.9 10.1 0 14-1.9 1.9-4.4 2.9-7 2.9z"></path>
                                          </svg>
                                       </button>
                                     
                                    </div>
                           <div class="sidebar-block blogs-bestseller">
                              <?php   foreach ($list_att_gr as $list){
                                 $att_set = \common\models\AttSetHasAttGroup::find()->where('att_set_id='.$list->att_set_id)->all();
                                 foreach ($att_set as $list2){
                                   //echo $list->att_group_id."<hr>";
                                 $list_att = \common\models\AttGroupHasAtt::find()
                                 ->where('att_group_id='.$list2->att_group_id)
                                 ->all();
                                 foreach($list_att as $att){
                                 // echo $att->att_id;
                                 $attibuteList = \common\models\Att::find()
                                 ->where('id='.$att->att_id)
                                 ->all();
                                 foreach($attibuteList as $attbiute){
                                 
                                 $attvalue = \common\models\AttValue::find()->where("att_id=".$attbiute->id)->all();
                                 ?>
                              <?php if($attbiute->type==4){ ?>
                               <div class="graybox-2">
                              <h3 class="sidebar-title"><label><?= $attbiute->name; ?></label></h3>
                              <ul class="filter-content">
                                 
                                 <li><input type="checkbox"  name="yes[]" value="<?=$at->att_id; ?>"  ></li>
                                 <label >دارد</label>
                                 <li><input type="checkbox"name="no[]" value="<?= $at->att_id; ?>"></li>
                                 <label >ندارد</label>
                              </ul>
                               </div>
                              <?php  } ?>
                              <?php if($attbiute->type==5){ 
                                  
                                 $op= \common\models\AttOption::find()->where(['att_id'=>$attbiute->id])->all(); ?>
                              <div class="graybox-2">
                                  <h3 class="sidebar-title"><label><?= $attbiute->name; ?></label></h3>
                              
                              <div class="slecxtx">
                              <?php  $c=count($op); foreach ($op as $opp){
                                 ?>
                              <ul class="filter-content">
                                  <input type="checkbox"  name="option[]" value="<?= $opp->id ?>" ></li><label for="<?= $opp->id; ?>"><?= $opp->name; ?></label>
                              </ul>
                              
                              <?php } ?>
                              </div>
                                <?php if($c>4){ ?>
                                  <label class="more"><?php  if($c>4){echo $c-4;} ?> مورد بیشتر  +   </label>
                                <?php } ?>
                                <label class="minus">- موارد کمتر</label>
                              </div>
                                  <?php }?>
                               
                               
                               
                            
                           
                              <?php } } } }?>
                               
                               
                               
                              <input type="hidden" name="cat_id" value="<?= $_GET['id'] ?>" />
                              
                              
                              <div class="form-submit">
                                 <?= Html::submitButton('جستجو', ['class' => ' awe-btn awe-btn-1 awe-btn-medium  ']) ?>
                              </div>
                             
                           </div>
                            
                             <?php ActiveForm::end(); ?>
                            
                        </div>
                     </div>
                      
                    
                      
                  </div>
               </div>
            </div>
         </div>
          <div class="col-md-8 col-md-offset-4">
<?php
  
       ?>   
</div>
          </section>
</main>
</div>

