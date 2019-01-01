<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shiping".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property string $longitude
 * @property string $atitude
 */
class Shiping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shiping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'longitude', 'atitude'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'longitude' => 'Longitude',
            'atitude' => 'Atitude',
        ];
    }
}
