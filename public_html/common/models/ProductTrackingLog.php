<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_tracking_log".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $status
 * @property string $time
 *
 * @property ProductOrder $order
 */
class ProductTrackingLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_tracking_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'time'], 'required'],
            [['order_id', 'status'], 'integer'],
            [['time'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductOrder::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(ProductOrder::className(), ['id' => 'order_id']);
    }
}
