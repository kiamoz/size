<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_has_att_group".
 *
 * @property integer $att_group_id
 * @property integer $category_id
 *
 * @property ProductAttGroup $attGroup
 * @property ProductCategory $category
 */
class ProductCategoryHasAttGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   
    public static function tableName()
    {
        return 'product_category_has_att_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['att_group_id', 'category_id'], 'required'],
            [['att_group_id', 'category_id'], 'integer'],
            [['att_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttGroup::className(), 'targetAttribute' => ['att_group_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'att_group_id' => 'Att Group ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttGroup()
    {
        return $this->hasMany(ProductAttGroup::className(), ['id' => 'att_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }
 
}
