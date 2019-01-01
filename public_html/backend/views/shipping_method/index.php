<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\Viewdd */
/* @var $searchModel app\models\shipping_methodS */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shipping Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-method-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shipping Method', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'desc:ntext',
            
            [
    'class' => 'yii\grid\ActionColumn',
                  
    'template'=>'{edit}{delete}',
    'buttons' => [
        'view' => function ($url, $model, $key) {
                $options = ['target' => '_blank',];
      return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view','id'=>$model->id]));            
        },
        'edit' => function ($url, $model, $key) {
               $options = ['target' => '_blank',];
      return Html::a(' <span class="glyphicon glyphicon-pencil"></span>',Url::to(['update','id'=>$model->id]));            
        },
         
     
    ],
],
                
                 ['class' => 'yii\grid\CheckboxColumn',],
                
       
        ],
    ]); ?>
</div>
