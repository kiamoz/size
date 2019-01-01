<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Att */

$this->title = 'Update Att: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Atts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="att-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
