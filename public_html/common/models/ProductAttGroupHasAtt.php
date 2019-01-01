<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_att_group_has_att".
 *
 * @property integer $att_group_id
 * @property integer $att_id
 */
class ProductAttGroupHasAtt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_att_group_has_att';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['att_group_id', 'att_id'], 'required'],
            [['att_group_id', 'att_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'att_group_id' => 'Att Group ID',
            'att_id' => 'Att ID',
        ];
    }
   
    public function getProductAttValue()
    {
        return $this->hasOne(ProductAttValue::className(), ['att_id' => 'att_id']);
    }
      public function getAtt()
    {
        return $this->hasMany(Att::className(), ['id' => 'att_id']);
    }
}
