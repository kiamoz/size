<?php

use yii\helpers\Html;

$this->title = 'نظر جدید';
$this->params['breadcrumbs'][] = ['label' => 'نظرات', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
