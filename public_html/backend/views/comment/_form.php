<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
?>

<div class="comment-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

          <?PHP
        $br = \common\models\Branch::find()->all();
        $data = array();
        foreach ($br as $data_items) {
            $data[$data_items->id] = $data_items->name;
        }

     echo $form->field($model, 'post_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['placeholder' => 'نام شعبه'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
     ?>
        
        <small>وضعیت : </small>
        <br>
        <label class="switch">
            <?php if($model->status==1){ ?>
            <input type="checkbox" checked name="Comment[status]">
            <?php } else{?>
            <input type="checkbox" name="Comment[status]">
            <?php } ?>
            <span class="slider round"></span>
        </label>
        <br>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
