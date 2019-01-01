<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 *
 * @property CategoryHasPost[] $categoryHasPosts
 */
class PostCategory extends \yii\db\ActiveRecord
{
    public  $temp_img;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id','menu_show','body'], 'safe'],
            [['name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'دسته بندی مادر',
            'name' => 'نام دسته بندی',
        ];
    }

    
    /* a function  that return the ctagoery anme by ID */
    public static function getCatName($id){
        $m = PostCategory::findOne($id);
        if(isset($m)){
         return $m->name;
        }
    }
    /* a function  that return the ctagoery parent ID anme by ID */
     public static function getParentID($id){
        $m = PostCategory::findOne($id);
        return $m->parent_id;
    }
    /* a function  that return the catgeory parent idis  */
    
    ///////
    
    
    
    /* a function  that check a ctagoery ahs child or not */
    
    
    
    
    public static function hastchilderen($id){
        $m = PostCategory::find()->where('parent_id='.$id)->all();
        if(count($m)>0){
            return 1;
        }else{
            return 0;
        }
        //return $m->name;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryHasPosts()
    {
        return $this->hasMany(CategoryHasPost::className(), ['category_id' => 'id']);
    }
}
