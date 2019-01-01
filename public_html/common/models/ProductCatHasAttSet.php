<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_cat_has_att_set".
 *
 * @property integer $product_cat_id
 * @property integer $att_set_id
 *
 * @property ProductCategory $productCat
 * @property AttSet $attSet
 */
class ProductCatHasAttSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_cat_has_att_set';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_cat_id', 'att_set_id'], 'required'],
            [['product_cat_id', 'att_set_id'], 'integer'],
            [['product_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_cat_id' => 'id']],
            [['att_set_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttSet::className(), 'targetAttribute' => ['att_set_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_cat_id' => 'Product Cat ID',
            'att_set_id' => 'Att Set ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCat()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttSet()
    {
        return $this->hasOne(AttSet::className(), ['id' => 'att_set_id']);
    }
}
