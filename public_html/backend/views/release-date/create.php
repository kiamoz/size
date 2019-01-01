<?php

use yii\helpers\Html;


$this->title = 'تاریخ انتشار جدید';
$this->params['breadcrumbs'][] = ['label' => 'تاریخ های انتشار', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="release-date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
