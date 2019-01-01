<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingHasLocation */

$this->title = 'Update Shipping Has Location: ' . $model->shipping_id;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Has Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shipping_id, 'url' => ['view', 'shipping_id' => $model->shipping_id, 'location_id' => $model->location_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shipping-has-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
