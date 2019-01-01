<?php

use yii\helpers\Html;

$this->title = ' شرکت جدید';
$this->params['breadcrumbs'][] = ['label' => 'شرکت ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
