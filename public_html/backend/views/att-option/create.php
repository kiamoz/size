<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AttOption */

$this->title = 'Create Att Option';
$this->params['breadcrumbs'][] = ['label' => 'Att Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
