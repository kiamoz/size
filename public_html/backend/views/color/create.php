<?php

use yii\helpers\Html;


$this->title = 'رنگ جدید';
$this->params['breadcrumbs'][] = ['label' => 'رنگ ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
