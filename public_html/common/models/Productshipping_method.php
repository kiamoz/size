<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shipping_method".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 */
class Productshipping_method extends \yii\db\ActiveRecord
{
    public $price , $extra_price,$default_price;
     public $free_shipping_price,$increase_rate;
    /**
     * @inheritdoc
     */
    
    public $locg;
    public static function tableName()
    {
        return 'product_shipping_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['desc'], 'string'],
            [['visibility','locg','default_price','free_shipping_price','increase_rate'], 'safe'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام',
            'desc' => 'توضیحات',
           'free_shipping_price'=>'حداقل مبلغ برای ارسال رایگان',
            'default_price'=>'هزینه حمل پیشفرض',
            'locg'=>'شهرهای که این روش ارسال را شامل میشوند',
            'increase_rate'=>'درصد افزایش قیمت مثبت یا منفی'
            
        ];
    }
    
 
}
