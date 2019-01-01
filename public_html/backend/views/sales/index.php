<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'جداول فروش';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('جدول فروش جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            array(
                'header' => 'تاریخ شروع  ',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {
                    return \common\models\Post::arabic_w2e($data->start_date);
                },
            ),
            array(
                'header' => 'میزان فروش',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {

                    if ($data->sales_amount) {
                        return \common\models\Post::arabic_w2e(number_format($data->sales_amount));
                    }
                },
            ),
            array(
                'header' => 'نام فیلم ',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {

                    
                        return common\models\Movie::findOne($data->movie_id)->title;
                    
                },
            ),
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
