<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name_and_fam')->textInput() ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'cell_number')->textInput() ?>
    <?= $form->field($model, 'phone_number')->textInput() ?>
    <?= $form->field($model, 'social_code')->textInput() ?>
    <?= $form->field($model, 'postal_code')->textInput() ?>

    <?php
    $items=array();
    $items=['10'=>'فعال','0'=>'غیرفعال'];
    

    echo $form->field($model, 'status')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'']    // options
        );

   
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
