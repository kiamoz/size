<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\Variant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="variant-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $pdata= common\models\Product::findOne($model->product_id);
    
                $m =common\models\OptionHasVariant::find()->where('variant_id='.$model->id)->all();
                foreach($m as $var){
                    $ret.= common\models\AttOption::findOne($var->option_id)->name." ";
                }
    
    ?>
    
    <br>
    <label><?php echo $pdata->name; ?><br><?= $ret; ?></label>
    <img src="/backend/web/<?php echo $pdata->image; ?>" width="50" >
    <?= $form->field($model, 'product_id')->textInput() ?>

   

            <?PHP
        if ($model->id) {


            $price->buying_rate = Product::get_price_v($model->id,FALSE,FALSE);
            $price->buying_rate = Product::get_price_v_buy($model->id);



            
        }
        ?>
    <?= $form->field($price, 'selling_rate')->textInput() ?>

    <?= $form->field($price, 'buying_rate')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>
    <?= $form->field($model, 'order')->textInput() ?>
    <?= $form->field($model, 'barcode')->textInput() ?>
    <?= $form->field($model, 'barcode_text')->textInput() ?>
   

    
    <?php if($model->img){
            ?>
        <img src="/backend/web/<?php echo $model->img; ?>" width="150" >
        <?php } ?>
       <?= $form->field($model, 'file')->fileInput(['id' => 'file_id']) ?>
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'ویرایش', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
