<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\AssetBundle;
class AppAsset extends AssetBundle
{
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

<div class="release-date-form panel col-md-8 col-md-push-4 col-xs-12">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?php

        use faravaghi\jalaliDatePicker\jalaliDatePicker;

echo $form->field($model, 'date')
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

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
