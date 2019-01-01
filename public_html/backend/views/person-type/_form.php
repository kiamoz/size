<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="person-type-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
