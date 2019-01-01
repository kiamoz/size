<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_rate".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property double $rate
 */
class ProductRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'integer'],
            [['rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'user_id' => 'کاربر',
            'product_id' => 'نام محصول',
            'rate' => 'امتیاز',
        ];
    }
}
