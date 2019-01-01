<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingHasLocation */

$this->title = $model->shipping_id;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Has Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-has-location-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'shipping_id' => $model->shipping_id, 'location_id' => $model->location_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'shipping_id' => $model->shipping_id, 'location_id' => $model->location_id], [
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
            'shipping_id',
            'location_id',
            'price',
            'extra_price',
        ],
    ]) ?>

</div>
