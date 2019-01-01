<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_transaction".
 *
 * @property integer $id
 * @property string $table_name
 * @property integer $table_id
 * @property string $datetime
 * @property integer $status
 * @property integer $bank_gateway_id
 */
class BankTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'bank_gateway_id'], 'integer'],
            [['datetime'], 'safe'],
            [['table_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'order_id' => 'Table ID',
            'datetime' => 'Datetime',
            'status' => 'Status',
            'bank_gateway_id' => 'Bank Gateway ID',
        ];
    }
}
