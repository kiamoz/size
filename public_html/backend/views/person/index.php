<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'اشخاص';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('شخص جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            'family',
            'birth_year',
            'birth_month',
            'birth_day',
            // 'birth_place_id',
            // 'image:ntext',
            // 'gallery:ntext',
            // 'biography:ntext',
            // 'contact:ntext',
            // 'awards:ntext',
            // 'sites:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
