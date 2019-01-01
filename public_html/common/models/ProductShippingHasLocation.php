<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shipping_has_location".
 *
 * @property integer $shipping_id
 * @property integer $location_id
 * @property string $price
 */
class ProductShippingHasLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   
    public static function tableName()
    {
        return 'product_shipping_method_has_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_id', 'location_id', 'price','free_shipping_price'], 'safe'],
            [['shipping_id', 'location_id'], 'integer'],
          
            [['extra_price','price'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shipping_id' => 'Shipping ID',
            'location_id' => 'Location ID',
            'price' => 'Price',
          
        ];
    }
           public function getShippingMethod() {
        return $this->hasOne(Productshipping_method::className(), ['id' => 'shipping_id']);
    }
           public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'location_id']);
    }
}
