<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'پست ها');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Yii::t('app', 'پست جدید'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow: auto; word-wrap: break-word;'],
        'columns' => [
            'id',
                [
                'header' => 'دسته بندی',
                'attribute' => 'category_id',
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => \yii\helpers\ArrayHelper::map(common\models\PostCategory::find()->all(), 'id', 'name'),
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => 'دسته بندی را فیلتر ',
                    ],
                ]),
                'value' => function($data) {
                    return \common\models\Post::getpostCatsName($data->id);
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data) {
                    if (strlen($data->title) > 10)
                        return common\models\Post::limitword($data->title, 10) . '...';
                    else {
                        return ($data->title);
                    }
                },
            ],
                ['class' => 'yii\grid\ActionColumn',
            ],
        ]
    ]);
    ?>

</div>



