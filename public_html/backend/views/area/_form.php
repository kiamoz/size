<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="color-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?PHP
        $b = common\models\location::find()->all();
        $date = array();
        foreach ($b as $Category) {
            $data[$Category->id] = $Category->name;
        }

        echo $form->field($model, 'city_id')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'یک شهر انتخاب کنید'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
