<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'پست جدید');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'پست ها'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
