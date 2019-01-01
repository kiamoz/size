<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\shipping_method */

$this->title = 'Update Shipping Method: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shipping-method-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
