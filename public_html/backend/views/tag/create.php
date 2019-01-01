<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = 'تگ جدید';
$this->params['breadcrumbs'][] = ['label' => 'تگ ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
