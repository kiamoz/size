<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AttSet */

$this->title = 'Create Att Set';
$this->params['breadcrumbs'][] = ['label' => 'Att Sets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
