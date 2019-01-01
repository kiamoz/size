<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'پست ها'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'پست جدید'), ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'ویرایش'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'حذف'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'مطمئنی ؟ '),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
            //'body',
            [
            'attribute'=>'thumb_nail',
            'value'=>'http://'.$_SERVER['SERVER_NAME'].'/backend/web/'.$model->thumb_nail,
            'format' => ['image'],
            ],
            'date',
            'link'
        ],
    ]) ?>

</div>
