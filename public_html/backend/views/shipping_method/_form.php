<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\shipping_has_location;
use kartik\select2\Select2; 
use common\models\location;

/* @var $this yii\web\View */
/* @var $model app\models\shipping_method */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipping-method-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>
    
    
    <?PHP
    
$b  = common\models\City::find()->all();
$date2 = array();
foreach( $b as $ProductCategory){
$data2[$ProductCategory->id] = $ProductCategory->name;
}
    
if($model->id){


$m = common\models\ShippingHasLocation::find()
     ->with('city')
     ->where('location_id='.$model->id)
     ->all();
$arr_select = array();

foreach($m as $list){
    
    $arr_select[] = $list->city->name;
}

}


$methods= common\models\ShippingHasLocation::find()->where(['shipping_id'=>$model->id])->all();
foreach ($methods as $method){
    $arr_select[]=$method->location_id;
}
echo Html::activeLabel($model,'locg');


echo Select2::widget([
    'name' => 'shipping_method[locg]',
    'data' => $data2,
    'options' => ['placeholder' => 'مکان', 'multiple' => true],
    'value' => $arr_select, // initial value
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 10
    ],
]);

echo Html::error($model,'locg');

?>
    <br>
      <?= $form->field($model, 'default_price')->textInput(['maxlength' => true]) ?>
    <br>
     <?= $form->field($model, 'free_shipping_price')->textInput(['maxlength' => true]) ?>
    <br>
      <?= $form->field($model, 'increase_rate')->textInput(['maxlength' => true]) ?>
    <br>
<?= $form->field($model, 'visibility')->radioList([
    '1' => 'عدم نمایش ','0' => 'نمایش']) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
