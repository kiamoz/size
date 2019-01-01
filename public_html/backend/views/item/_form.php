<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'en_name')->textInput() ?>
    
    <?= $form->field($model, 'summery')->textInput() ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'temp_img')->fileInput(['id' => 'file_id']) ?>
    
    
    <?PHP
        $itemcat = common\models\ItemCategory::find()->all();
        $data = array();
        foreach ($itemcat as $data_items) {
            $data[$data_items->id] = $data_items->name;
        }

     echo $form->field($model, 'item_category_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => 'نام گروه بندی'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
     ?>

        
     <br>
    <small>قیمت </small>
    <input type="text" name="price" ><br><br>
    
     <small>وضعیت ستاره دار بودن: </small>
        <br>
        <label class="switch">
            <?php if($model->is_star==1){ ?>
            <input type="checkbox" checked name="Item[is_star]">
            <?php } else{?>
            <input type="checkbox" name="Item[is_star]">
            <?php } ?>
            <span class="slider round"></span>
        </label>
        <br>

          <?= $form->field($model, 'back_color')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
