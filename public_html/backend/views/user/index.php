<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_and_fam',
            'username',
            array(
                'header' => ' آدرس',
                'format' => 'raw',
                //'attribute' => 'name_and_fam', 
                'value' => function($data) {


                    $_add = \common\models\Address::find()->where('user_id=' . $data->id)->all();
                    $_cnt = count($_add);
                    if ($_cnt > 0) {
                        return '<a target="_blank" href="' . Url::to(['address/index', 'id' => $data->id]) . '">' . \common\models\Post::arabic_w2e($_cnt) . "مورد " . '</a>';
                    } else {
                        return "-";
                    }
                },
                    ),
                    array(
                        'header' => ' سفارش',
                        'format' => 'raw',
                        //'attribute' => 'name_and_fam', 
                        'value' => function($data) {


                            $_ord = \common\models\Order::find()->where('user_id='.$data->id)->all();
                            $_cnt_ord=  count($_ord);
                            if ($_cnt_ord > 0) {
                                return '<a target="_blank" href="' . Url::to(['order/index_user', 'id' => $data->id]) . '">' . \common\models\Post::arabic_w2e($_cnt_ord) . "مورد " . '</a>';
                            } else {
                                return "-";
                            }
                        },
                            ),
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
</div>
