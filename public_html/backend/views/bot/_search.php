<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BotSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'chat_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'lat') ?>

    <?= $form->field($model, 'long') ?>

    <?php // echo $form->field($model, 'product') ?>

    <?php // echo $form->field($model, 'menu') ?>

    <?php // echo $form->field($model, 'branch') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
