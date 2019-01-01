<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\ProductAttGroup;
use common\models\ProductAttGroupHasAtt;

/* @var $this yii\web\View */
/* @var $model app\models\Att */
/* @var $form yii\widgets\ActiveForm */





?>

<div class="att-form">

    
    
    <?php $form = ActiveForm::begin(); ?>

   
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?PHP


?>
    <?PHP
    
    
   
    
    echo $form->field($model, 'type')->widget(Select2::classname(), [
    'data' => common\models\Att::type_arr,
    //'value' => 1, // initial value
    'options' => ['placeholder' => 'یک برند انتخاب کنید'],
    'pluginOptions' => [
        'allowClear' => true
    ]]);
    
    ?>
            

    <?PHP
    
$b  = ProductAttGroup::find()->all();
$date = array();
foreach( $b as $AttGroup){
$data[$AttGroup->id] = $AttGroup->name;

}
    
if($model->id){


$m = ProductAttGroupHasAtt::find()
     ->with('att')
     ->where('att_id='.$model->id)
     ->all();
$arr_select = array();
foreach($m as $list){
    
    $arr_select[] = $list->att_group_id;
}

}


echo Html::activeLabel($model,'attg');


echo Select2::widget([
    'name' => 'Att[attg]',
    'data' => $data,
    'options' => ['placeholder' => 'Select ....', 'multiple' => true],
    'value' => $arr_select, // initial value
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 10
    ],
]);

    

echo Html::error($model,'attg');

?>
    
    

    
     <?PHP 
    
 
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
