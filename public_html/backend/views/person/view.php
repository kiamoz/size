<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'اشخاص', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
        <?= Html::a('شخص جدید', ['create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'مطمئنی ؟ ',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'family',
            'birth_year',
            'birth_month',
            'birth_day',
            'birth_place_id',
           [
            'attribute'=>'image',
            'value'=>'http://'.$_SERVER['SERVER_NAME'].'/backend/web/'.$model->image,
            'format' => ['image',['width'=>'200','height'=>'150']],
            ],
            'gallery:ntext',
            'biography:ntext',
            'contact:ntext',
            'awards:ntext',
            'sites:ntext',
        ],
    ]) ?>

</div>
