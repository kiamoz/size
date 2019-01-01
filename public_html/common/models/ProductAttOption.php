<?php

namespace common\models;

use Yii;
class AttOption extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'product_att_option';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'name' => 'نام',
        ];
    }
}
