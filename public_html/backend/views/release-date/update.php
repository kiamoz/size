<?php

use yii\helpers\Html;


$this->title = 'ویرایش تاریخ انتشار: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'تاریخ های انتشار', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="release-date-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
