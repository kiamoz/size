<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ItemCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'order_show')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'is_star')->radioList(['1' => 'بله', '0' => 'خیر']); ?>
     <?= $form->field($model, 'temp_img')->fileInput(['id' => 'file_id']) ?>
    
    
    
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
