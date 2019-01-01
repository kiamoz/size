<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\ProductCategory;
use kartik\date\DatePicker;
use common\models\ProductCategoryHasCategory;
?> 
<div class="panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">


        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'menu_show')->radioList(array('1' => 'بله', '0' => 'خیر')); ?>
    
      
        <?= $form->field($model, 'order_show')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?PHP
        $b = ProductCategory::find()->all();
        $date2 = array();
        foreach ($b as $ProductCategory) {


            $ret = "";
            $daste = ProductCategoryHasCategory::find()->where('category=' . $ProductCategory->id)->all();
            foreach ($daste as $cats) {
                $ret.= \common\models\ProductCategory::findOne($cats->parent_category)->name . " ";
            }

            $data2[$ProductCategory->id] = $ProductCategory->name . "(" . $ret . ")";
        }

        if ($model->id) {


            $m = ProductCategoryHasCategory::find()
                    ->where('category=' . $model->id)
                    ->all();
            $arr_select = array();
            foreach ($m as $list) {

                $arr_select[] = $list->parent_category;
            }
        }

        $b = common\models\ProductAttGroup::find()->all();
        $date = array();
        foreach ($b as $AttGroup) {
            $data[$AttGroup->id] = $AttGroup->name;
        }


        if ($model->id) {


            $m = \common\models\ProductCategoryHasAttGroup::find()
                    ->where('category_id=' . $model->id)
                    ->all();
            $arr_select2 = array();
            foreach ($m as $list) {

                $arr_select2[] = $list->att_group_id;
            }
        }


        


         echo $form->field($model, 'att_group_id')->widget(Select2::classname(), [
           
            'data' => $data,
            'options' => ['placeholder' => 'پکیج', 'multiple' => true],
            'value' => $arr_select2, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);



        echo Html::error($model, 'att_group_id');


        echo Html::activeLabel($model, 'attrchc');


        echo Select2::widget([
            'name' => 'ProductCategory[attrchc]',
            'data' => $data2,
            'options' => ['placeholder' => 'دسته بندی مشترک', 'multiple' => true],
            'value' => $arr_select, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);



        echo Html::error($model, 'attrc');
        ?>
        <?php
//echo '<label>تاریخ</label>';
//echo DatePicker::widget([
//	'name' => 'ProductCategory[date]', 
//	'value' => $model->date,
//	'options' => ['placeholder' => 'تاریخ را انتخاب کنید'],
//	'pluginOptions' => [
//		'format' => 'dd-m-yyyy',
//		'todayHighlight' => true
//	]
//]);     
        ?>
        <br>
        <?= $form->field($model, 'is_mother')->checkbox(); ?>

        <?= $form->field($model, 'file')->fileInput(['id' => 'imgInp']) ?>
        <?php if (strlen($model->img) > 2) { ?>
            <img id="imgInp_"  src="<?= $model->img; ?>" alt="تصویر " width="200"/>
        <?php } else { ?>
            <img id="imgInp_" src="img/no_image.png" alt="تصویر " width="200"/>
        <?php } ?>
        <br>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $("#" + input.id + "_").attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {

        readURL(this);
    });
</script>