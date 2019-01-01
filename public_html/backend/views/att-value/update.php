<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AttValue */

$this->title = 'Update Att Value: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Att Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="att-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
