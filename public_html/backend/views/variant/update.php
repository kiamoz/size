<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Variant */

$this->title = 'Update Variant: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Variants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="variant-update">

    <?= $this->render('_form', [
        'model' => $model,
        'price'=>$price,
    ]) ?>

</div>
