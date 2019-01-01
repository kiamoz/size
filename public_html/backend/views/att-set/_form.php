<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\AttSet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="att-set-form">

    <?php $form = ActiveForm::begin(); ?>

    
    
    
   
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    
    <?php
    
$b  = common\models\AttGroup::find()->all();

foreach( $b as $ProductCategory){
$data2[$ProductCategory->id] = $ProductCategory->name;

}
    

if($model->id){


$m = \common\models\AttSetHasAttGroup::find()
     ->where('att_set_id='.$model->id)
     ->all();
$arr_select = array();
foreach($m as $list){
    
    $arr_select[] = $list->att_group_id;
}

}



echo Html::activeLabel($model,'attrc');


echo Select2::widget([
    'name' => 'att_g_id',
    'data' => $data2,
    'options' => ['placeholder' => 'Select ....', 'multiple' => true],
    'value' => $arr_select, // initial value
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 10
    ],
]);

    

echo Html::error($model,'attrc');
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
