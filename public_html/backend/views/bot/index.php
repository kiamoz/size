<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bots';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-index">

    <h1>گزارش بات</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            //'chat_id',
            'date',
            'lat',
            'long',
            'product',
             'menu',
             'branch',

            
        ],
    ]); ?>
</div>
