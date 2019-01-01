<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AttGroup */

$this->title = 'Update Att Group: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Att Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="att-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
