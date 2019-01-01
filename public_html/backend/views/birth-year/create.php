<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BirthYear */

$this->title = 'Create Birth Year';
$this->params['breadcrumbs'][] = ['label' => 'Birth Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="birth-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
