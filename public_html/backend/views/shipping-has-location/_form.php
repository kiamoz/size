<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingHasLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $a = common\models\shipping_method::find()->all();
    foreach($a as $ship){
        $data[$ship->id] = $ship->name;
    }

    
?>


<div class="shipping-has-location-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'shipping_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => 'یک مدل ارسال انتخاب کنید'],
    'pluginOptions' => [
    'allowClear' => true
    ],
    
]);


?>

   

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'extra_price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
