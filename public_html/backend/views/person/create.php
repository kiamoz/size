<?php

use yii\helpers\Html;

$this->title = 'شخص جدید';
$this->params['breadcrumbs'][] = ['label' => 'اشخاص', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
