<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShippingHasLocation */

$this->title = 'Create Shipping Has Location';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Has Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-has-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
