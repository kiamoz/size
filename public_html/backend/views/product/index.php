<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;

$this->title = 'محصولات';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1 class="mb10"><?= Html::encode($this->title) ?></h1>


    <p class="mb10">
        <?= Html::a('محصول جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow: auto; word-wrap: break-word;'],
        'columns' => [
               'id',
            'order_show',

            
            [
                'header' => 'دسته بندی',
                'attribute' => 'category_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => \yii\helpers\ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'name'),
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'دسته بندی را فیلتر ',
                    ],
                ]),
                'value' => function($data) {
                    return \common\models\Product::getCategory_name($data->id);
                },
            ],
            
            
            'name',
            'code',
            'qty',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
