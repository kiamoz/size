<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'محله ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    

    <p>
        <?= Html::a(' محله جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
             [
                'header' => 'نام شهر',
                'format' => 'raw',
                'value' => function ($model) {        
                    
                   return \common\models\City::getName($model->city_id);
                    
                      
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
