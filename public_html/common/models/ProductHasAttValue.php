<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_has_att_value".
 *
 * @property integer $product_id
 * @property integer $att_value_id
 *
 * @property AttValue $attValue
 * @property Product $product
 */
class ProductHasAttValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_has_att_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'att_value_id'], 'required'],
            [['product_id', 'att_value_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'att_value_id' => 'Att Value ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttValue()
    {
        return $this->hasOne(AttValue::className(), ['id' => 'att_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
