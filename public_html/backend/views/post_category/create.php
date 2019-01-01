<?php

use yii\helpers\Html;


$this->title = 'دسته بندی جدید';
$this->params['breadcrumbs'][] = ['label' => 'دسته بندی ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
