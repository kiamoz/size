<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_att_value".
 *
 * @property integer $id
 * @property integer $att_id
 * @property integer $product_id
 * @property string $value
 * @property string $price
 */
class ProductAttValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_att_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['att_id', 'product_id', 'value'], 'required'],
            [['att_id', 'product_id'], 'integer'],
            [['value'], 'string'],
            [['price'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'att_id' => 'Att ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'price' => 'Price',
        ];
    }
}
