<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
   $shipping_methods= ArrayHelper::map(\common\models\shipping_method::find()->all(), 'id','name');
                                   
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->radioList( common\models\Order::status_text ) ?>
              
        <?= $form->field($model, 'payment_id')->radioList( common\models\Order::payment ) ?>
      <?= $form->field($model, 'shipping_method_id')->radioList( $shipping_methods ) ?>
                          
 
 
    
   
    
 
  
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
