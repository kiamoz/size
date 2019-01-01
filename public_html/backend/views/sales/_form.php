<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use faravaghi\jalaliDatePicker\jalaliDatePicker;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
?>

<div class="sales-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">

<?php $form = ActiveForm::begin(); ?>


        <hr>


        <?php
        echo $form->field($model, 'start_date')
                ->widget(
                        jalaliDatePicker::className(), [
                    'options' => array(
                        'format' => 'yyyy/mm/dd',
                        'viewformat' => 'yyyy/mm/dd',
                        'placement' => 'left',
                        'todayBtn' => 'linked',
                    ),
                    'htmlOptions' => [
                        'id' => 'date',
                        'class' => 'form-control'
                    ]
        ]);
        ?>



        <br><br>
        <?= $form->field($model, 'amount_format')->textInput(['class' => 'maskm form-control']) ?>

        <hr>
        <small>نام فیلم</small>
        <?PHP
        $data_item_1 = common\models\Movie::find()->all();
        $data_1 = array();
        foreach ($data_item_1 as $data_items_1) {
            $data_1[$data_items_1->id] = $data_items_1->title;
        }

        echo Select2::widget([
            'name' => 'Sales[movie_id]',
            'data' => $data_1,
            'options' => ['placeholder' => 'نام فیلم'],
            'value' => $model->movie_id, // initial value
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
        ?>
        <br>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
