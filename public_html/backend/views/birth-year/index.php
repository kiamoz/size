<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BirthYearS */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Birth Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="birth-year-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Birth Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'b_year',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
