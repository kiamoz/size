<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="person-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'family') ?>

    <?= $form->field($model, 'birth_year_id') ?>

    <?= $form->field($model, 'birth_month_day_id') ?>

    <?php // echo $form->field($model, 'birth_place_id') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'gallery') ?>

    <?php // echo $form->field($model, 'biography') ?>

    <?php // echo $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'awards') ?>

    <?php // echo $form->field($model, 'sites') ?>

    <div class="form-group">
        <?= Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
