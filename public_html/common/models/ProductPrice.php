<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_price".
 *
 * @property integer $id
 * @property string $update_date
 * @property integer $product_id
 * @property integer $variant_id
 * @property string $price
 * @property integer $sale_price
 */
class ProductPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['update_date'], 'safe'],
            [['product_id'], 'safe'],
            [['product_id', 'variant_id'], 'integer'],
            [['selling_rate','buying_rate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'update_date' => 'Update Date',
            'product_id' => 'Product ID',
            'variant_id' => 'Variant ID',
            'selling_rate' => 'قیمت فروش',
            'buying_rate' => 'قیمت خرید',
        ];
    }
}
