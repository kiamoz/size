<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Bot */

$this->title = $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Bots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->chat_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->chat_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'chat_id',
            'date',
            'lat',
            'long',
            'product',
            'menu',
            'branch',
        ],
    ]) ?>

</div>
