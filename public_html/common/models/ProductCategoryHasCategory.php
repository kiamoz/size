<?php

namespace common\models;

use Yii;
use common\models\ProductCategory;

/**
 * This is the model class for table "category_has_category".
 *
 * @property integer $parent_category
 * @property integer $category
 */
class ProductCategoryHasCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category_has_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_category', 'category'], 'required'],
            [['parent_category', 'category'], 'integer'],
        ];
    }
    
    public static function has_child($id)
    {
        return  CategoryHasCategory::find()->where('parent_category='.$id)->count();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_category' => 'Parent Category',
            'category' => 'Category',
        ];
    }
    
    public function getProductCategory()
    { 
        return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
    }
     
}
