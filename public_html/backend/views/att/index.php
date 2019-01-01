<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="att-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Att', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            
            array(
            'header'=>'نام',     
            
            'attribute' => 'name', 
            'value'=>function($data) { 
                       
            
               $m = \common\models\ProductAttGroupHasAtt::find()->where('att_id='.$data->id)->all();
                foreach($m as $attg){
                    $list.= common\models\ProductAttGroup::findOne($attg->att_group_id)->name."-";
                }
          
        return $data->name."(".$list.")";
            
            } 
            
            ),
            
             array(
            'header'=>'نوع ',     
            'format' => 'raw',
            //'attribute' => 'name_and_fam', 
            'value'=>function($data) { 
                             
                             
                         $listname = array(
                              1=>"متنی",
                              2=>"متنی طولانی",
                              4=>"دارد ندارد",
                              5=>"دارای آپشن",
                             
                         );
                                 
                             
                             return $listname[$data->type]; 
                             
            },

             ),
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
