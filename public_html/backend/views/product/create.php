<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'محصول جدید');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'محصولات'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
