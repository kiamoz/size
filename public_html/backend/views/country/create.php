<?php

use yii\helpers\Html;

$this->title = 'کشور جدید';
$this->params['breadcrumbs'][] = ['label' => 'کشور ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
