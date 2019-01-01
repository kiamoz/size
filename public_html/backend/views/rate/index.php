<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'امتیازات';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-index">

    <h1><?= Html::encode($this->title) . ' ' . \common\models\Movie::findOne($_GET['id'])->title; ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'header' => 'کاربر ',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {


                    $usr = \common\models\User::findOne($data->user_id);

                    return $usr->username;
                },
            ),
            array(
                'header' => 'امتیاز ',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {

                    return common\models\Post::arabic_w2e($data->rate);
                },
            ),
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
