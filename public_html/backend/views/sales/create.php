<?php

use yii\helpers\Html;

$this->title = 'جدول فروش جدید';
$this->params['breadcrumbs'][] = ['label' => 'جدول فروش', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
