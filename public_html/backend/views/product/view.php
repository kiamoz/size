
<style>
    .select2s{
        width: 500px;
    }
    span.select2.select2-container.select2-container--krajee{
        margin-top: 7px;
    }
    span.select2-selection.select2-selection--multiple , .select2-results__option{
        text-align: right;
        direction: rtl;
    }
    .select2-container .select2-search--inline{
        float: right;
        width: auto;
    }
    .select2-container--krajee .select2-selection--multiple .select2-selection__choice{
        float: right;
        margin: 5px 4px 0 6px;
    }
    
    tr img {
    max-width: 160px;
    }
    </style>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Product;
use yii\helpers\url;
use kartik\select2\Select2; 
use common\models\ProductAtt;


$this->title = $model->name."*";
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date',
            [
            'attribute'=>'لینک',
            'format' => 'url',   
            'value'=> 
                function ($data) {
                if($data->link){
                return 'http://'.$_SERVER['SERVER_NAME'].'/backend/web/'.$model->link;
                }
            },
                
                
            ],
            [
            'attribute'=>'thumbnail',
            'value'=>'http://'.$_SERVER['SERVER_NAME'].'/backend/web/'.$model->image,
            'format' => ['image'],
            ],
           
                    
           
            
        ],
    ]) ?>
    
    <?PHP
    echo $model->date; 
    if(file_exists($site_base.'/backend/web/'.$model->image)){
       echo Product::resize_img($site_base.'/backend/web/'.$model->image	, 90,90, "_".$model->id);
    }
    
    ?>
    
    
     <p>
        <?= Html::a('ثبت ویژگی های محصول', ['setatt', 'id' =>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
    
     <?php $form = ActiveForm::begin(['action' =>['product/saveoptionvalue']]); ?>
    
<?php

$all_option_name= ProductAtt::find()->where(['type'=>5])
        ->all();
$option_name_array=  array();
foreach ($all_option_name as $all_option_names)
{
    $option_name_array[$all_option_names->id]=$all_option_names->name;
}

echo Select2::widget([
    'name' => '',
    'data' => $option_name_array,
    'options' => ['placeholder' => 'یک آپشن انتخاب کنید'],

    'pluginOptions' => [
        
        'maximumInputLength' => 10
    ],
]); ?>
<input type="hidden" value="<?php echo $model->id; ?>" name="product_id"> 
<br><br>
<a class="btn btn-success" href="javascript:void(0)" id="makevariant">انتخاب این ویژگی</a>
<br><br>
<div id="layout"></div>  
<button class="btn btn-primary send">مرحله بعد</button>
<?php ActiveForm::end(); ?>
 
</div> 
    
    