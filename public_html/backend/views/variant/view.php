<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Variant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Variants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <a target="_blank" class="btn_barcode" href="http://pet-met.ir/backend/web/barcode/master/src/index.php?pid=0<?php echo $model->id; ?>&name2=<?php echo $model->barcode_text; ?>">Print Barcode</a>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'img',
            'price',
            'qty',
        
        ],
    ]) ?>

</div>
