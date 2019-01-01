<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('کاربر جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'name_and_fam',
            
            'name_and_fam',
            
           
            'username',
          
            
           // 'auth_key',
            //'password_hash',
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'cell_number',
            // 'phone_number',
            // 'social_code',
            // 'address',
            // 'postal_code',
            // 'sh_number',
            // 'madrak',
            // 'tahsil',
            // 'home_number',
            // 'daneshgah',
            // 'addres_work',
            // 'name_father',
            // 'khabar',
            // 'file',
            // 'gender',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
