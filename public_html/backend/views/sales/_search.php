<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="sales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'sales_amount') ?>

    <?= $form->field($model, 'movie_id') ?>

    <div class="form-group">
        <?= Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
