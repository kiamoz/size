<?php

use yii\helpers\Html;


$this->title = 'ژانر جدید';
$this->params['breadcrumbs'][] = ['label' => 'ژانر', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
