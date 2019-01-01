<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use common\models\Order;
use common\models\Post;
use common\models\User;
use yii\helpers\ArrayHelper;

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow: auto; word-wrap: break-word;'],
        'rowOptions' => function ($model, $index, $widget, $grid) {

            if ($model->status == 2) {
                return ['class' => 'green'];
            }
        },
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'id',
            array(
                'header' => 'تاریخ',
                'format' => 'raw',
                'value' => function($data) {


                    return $data->date_farsi;
                }
            ),
                [
                'header' => ' وضعیت سفارش',
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => Order::status_text,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'select..',
                    ],
                ]),
                'value' => function ($model) {
                    return Order::status_text[$model->status];
                },
            ],
            array(
                'header' => 'شماره همراه',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {


                    $usr = User::findOne($data->user_id);

                    return Post::arabic_w2e($usr->cell_number);
                },
            ),
            array(
                'header' => ' نام سفارش دهنده(تلفن همراه)',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {


                    $usr = User::findOne($data->user_id);

                    return '<a target="_blank" href="' . Url::to(['order/index_user', 'id' => $data->user_id]) . '">' . $usr->name_and_fam . ' ' . \common\models\Post::arabic_w2e($usr->cell_number) . '</a>';
                },
            ),
            array(
                'header' => 'مبلغ سفارش',
                'format' => 'raw',
                // 'attribute' => 'some_title',
                'value' => function($data) {

                    return Post::arabic_w2e(number_format($data->price_final));
                },
            ),
           
                ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-print"></span>', Url::to(['view', 'id' => $model->id]), ['class' => ' label']);
                    },
                   
                ],
            ],
        ]
    ]);
    ?>

</div>
