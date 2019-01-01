<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
?>
<style>
    img{
        max-width:200px;
    }
</style>
<div class="sitesetting-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body"> 
        <?php $form = ActiveForm::begin(); ?>
        
        <b>تنظیمات اپلیکشن</b>
        <hr>
        
        <?= $form->field($model, 'app_main_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label('تنظیم رنگ  اصلی اپلیکشن / دکمه ها / هاور دکمه ها / '); ?>
        <?= $form->field($model, 'app_menu_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label(' تنظیم رنگ منو راست اپلیکشن '); ?>

        
        <hr>
              
              
        <?= $form->field($model, 'font_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label('تنظیم رنگ فونت'); ?>
        <?= $form->field($model, 'hover_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label(' تنظیم رنگ هاور '); ?>

        <?= $form->field($model, 'main_color')->textInput(['maxlength' => 255, 'class' => 'jscolor'])->label(' تنظیم رنگ اصلی '); ?>
        <?= $form->field($model, 'favv')->fileInput(['id' => 'file_id']) ?>
        <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->fav; ?>" >
        <br>
        <hr>
        <br>
        <?= $form->field($model, 'logoo')->fileInput(['id' => 'file_id2']) ?>
        <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $model->logo; ?>" >
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'credit_recommended')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'credit_recommender')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'is_load_all_categories')->radioList(array('1' => 'نمایش همه دسته بندیها', '0' => ' نمایش دسته بندیهای مرتبط  ')); ?>
        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'googleplus')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'aparat')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'tell')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'saat_kar')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'pagination')->textInput(['maxlength' => true])->label(' تنظیم تعداد پست محصولات در هر صفحه  '); ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script src="jscolor.js"></script>