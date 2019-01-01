<?php

use yii\helpers\Html;

$this->title = 'ویرایش رنگ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'رنگ ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
