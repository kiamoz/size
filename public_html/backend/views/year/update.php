<?php

use yii\helpers\Html;

$this->title = 'ویرایش سال ساخت: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'سالهای ساخت', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
