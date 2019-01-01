<?php

use yii\helpers\Html;

$this->title = 'شغل جدید';
$this->params['breadcrumbs'][] = ['label' => 'شغل ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
