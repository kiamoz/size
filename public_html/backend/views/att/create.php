<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Att */

$this->title = 'Create Att';
$this->params['breadcrumbs'][] = ['label' => 'Atts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
