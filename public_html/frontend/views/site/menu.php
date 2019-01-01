<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;

$this->title = "منو";
$site_base = dirname(dirname(dirname(dirname(__FILE__))));
?>
<section  class="product-single ">
    <div class="container" style="padding-top: 50px;">
        <div class="row">
            <div class="item-index">

                
                <div class="row">
                    <div class="col-md-3 col-xs-12 " style="float: right;    margin-top: -32px;"><section class="accardion" >
    <?php
                        $itemcat = \common\models\ItemCategory::find()->all();

                        foreach ($itemcat as $cat) {
                            $item = \common\models\Item::find()->where('item_category_id=' . $cat->id)->all();
                            //echo count($item);
                            ?>
  <div>
      <input id="ac-<?= $cat->id ?>" name="accordion-<?= $cat->id ?>" type="checkbox" />
		<label for="ac-<?= $cat->id ?>"><?= $cat->name ?></label>
<?php foreach ($item as $items) { ?>
		<article class="ac-small">
			        <a href="<?= Url::to(['/item/view', 'id' => $items->id]) ?>"> <p><?= $items->name ?></p> </a>
		</article>
	 <?php }
                                ?>
                            </div>
                            <?php }
                        ?>
</section></div>
               
                <div class="col-md-9 col-xs-12   menu-item-in">
                    <div class="row">
                        
                        
                            <?php 
                            
                             $itemcat = \common\models\ItemCategory::find()->where('is_star=1')->all();
                            
                            foreach ($itemcat as $cat) { ?>
                            <div class="col-md-4">
                                <a href="<?= Url::to(['site/sub_menu','id'=>$cat->id]) ?>">
                                 <img src="<?PHP echo common\models\Post::resize_img($site_base . '/backend/web/' . $cat->img, 307, 200, "_" . $cat->id); ?>" alt="<?= $cat->name; ?>">
                                </a>
                                <h2><a href="<?= Url::to(['site/sub_menu','id'=>$cat->id]) ?>"><?= $cat->name ?></a></h2>
                            </div>
                            <?php } ?>
                       
                        
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    </div>
    
</section>