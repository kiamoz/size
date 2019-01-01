<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VariantS */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Variants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'barcode_text',
            'barcode',
            'price',
            'qty',
            array(
            'header'=>'تنوع ',     
            'format' => 'raw',
            'value'=>function($data) { 
                   
                
                
                $m =common\models\OptionHasVariant::find()->where('variant_id='.$data->id)->all();
                foreach($m as $var){
                    $ret.= common\models\OptionValue::findOne($var->option_id)->name.",";
                }
                
               return $ret;
                            
                             
                             
            },
            ),
            // 'avl',
            // 'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
