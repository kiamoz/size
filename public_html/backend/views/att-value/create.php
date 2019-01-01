<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AttValue */

$this->title = 'Create Att Value';
$this->params['breadcrumbs'][] = ['label' => 'Att Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
