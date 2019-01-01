<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1>آیتم ها</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
