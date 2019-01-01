<?php

use yii\helpers\Html;

$this->title = 'سال ساخت جدید';
$this->params['breadcrumbs'][] = ['label' => 'سالهای  ساخت', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
