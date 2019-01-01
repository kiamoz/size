<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Att;
/* @var $this yii\web\View */
/* @var $model app\models\AttValue */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="att-value-form">

    <?php $form = ActiveForm::begin(); ?>
<?PHP

$b  = Att::find()->where("type=2")->all();
$date = array();
foreach( $b as $att){
$data[$att->id] = $att->name;
}

echo $form->field($model, 'att_id')->widget(Select2::classname(), [
    'data' => $data,
    'options' => ['multiple' => true,'placeholder' => 'یک برند انتخاب کنید'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    
]);


?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
