<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AttGroup */

$this->title = 'Create Att Group';
$this->params['breadcrumbs'][] = ['label' => 'Att Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
