<?php

use yii\helpers\Html;


$this->title = 'زبان حدید';
$this->params['breadcrumbs'][] = ['label' => 'زبان ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
