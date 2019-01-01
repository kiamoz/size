<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $this yii\web\View */
/* @var $model common\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class=" col-md-9" style="float: right; margin-right: 200px;">
<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adrs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel')->textInput() ?>
    
     <?= $form->field($model, 'hours')->textInput() ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
 
        <div id="gallery-box">
            <?php
            echo FileInput::widget([
                'name' => 'file[]',
                'options' => [
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'uploadUrl' => Url::to(['upload']),
                    'uploadExtraData' => [
                        'insert_id' => $last_id,
                    ],
                    'maxFileCount' => 10
                ],
            ]);
            ?>
        <?= $form->field($model, 'gallery')->textarea(['rows' => 6]) ?>
            
        </div>
        <?php
        $m = explode("\n", $model->gallery);
        $items_arr = array();
        foreach ($m as $imgx) {
            //echo "*".$imgx;
             $imgx = str_replace("http://", "https://", $imgx);
            if ($imgx == "") {
                continue;
            }
            ?>
            <div  class="file-preview-frame file-preview-success " id="uploaded-1494563246882" data-fileindex="-1" data-template="image">
                <div class="kv-file-content">
                    <img src="<?= $imgx ?>" class="kv-preview-data file-preview-image"  style="width:auto;height:160px; ">
                </div>
                <div class="file-thumbnail-footer">
                    <div class="file-actions ">
                        <div class="file-footer-buttons">
                            <button type="button" class="kv-file-remove btn btn-xs btn-default removex" title="<?= $imgx ?>"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    
    <div class=" clearfix"></div>

    <h4>محصولات ارائه شده در شعبه:</h4>
    <br>
     <?PHP
        $item = common\models\Item::find()->all();
        $data = array();
        foreach ($item as $data_items) {
            $data[$data_items->id] = $data_items->name;
        }
        
        if($model->id){
         $selected=array();
            foreach(   \common\models\ItemHasBranch::find()->where('branch_id='.$model->id)->all() as $item){
                array_push($selected, $item->item_id )  ;
            }
        }

        echo Select2::widget([
            'name' => 'items',
            'data' => $data,
            'options' => ['placeholder' => 'نام   آیتم',
                'multiple'=>TRUE],
           'value' => $selected, // initial value
            'pluginOptions' => [
             //   'tags' => true,
                
                'maximumInputLength' => 10
            ],
        ]);
        ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
  </div>