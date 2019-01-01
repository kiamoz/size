<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Att */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Atts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
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
           
            'name',
            'type_human',
        ],
    ]) ?>
   <?php if($model->type==5){ ?>
     <p>
        <?= Html::a('اضافه کردن آپشن', ['/att-option/create', 'id' =>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
  
            'name',
           [
    'class' => 'yii\grid\ActionColumn',
                  
    'template'=>'{edit}{delete}',
    'buttons' => [
       
        'edit' => function ($url, $model, $key) {
               $options = ['target' => '_blank',];
      return Html::a(' <span class="glyphicon glyphicon-pencil"></span>', "http://".$_SERVER['SERVER_NAME']."/backend/web/index.php?r=att-option%2Fupdate&id=".$model->id,$options);            
        },
       'delete' => function ($url, $model, $key) {
               $options = ['target' => '_blank',];
      return Html::a(' <span class="glyphicon glyphicon-trash"></span>', "http://".$_SERVER['SERVER_NAME']."/backend/web/index.php?r=att-option%2Fdelete&id=".$model->id,$options);            
        },
              
                
                
              
                
       
    ],
],
     
        ],
    ]); ?>
   <?php } ?>
</div>
