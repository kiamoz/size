<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_item".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $qty
 * @property string $desc
 * @property integer $variant_id
 */
class ProductItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'order_id', 'qty', 'variant_id'], 'integer'],
            [['desc'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
            'qty' => 'Qty',
            'desc' => 'Desc',
            'variant_id' => 'Variant ID',
        ];
    }
     public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    public function getOrderHasItems() {
        return $this->hasMany(OrderHasItem::className(), ['item_id' => 'id', 'item_product_id' => 'product_id']);
    }

    static public function add_new_item_to_order($order_id, $product_id) {

      
        if ($product_id) {
            $_product = Product::findOne($product_id);
            $p = ProductItem::find()
                    ->where(" order_id =" . $order_id . " and product_id=" . $product_id)
                    ->one();
        }
        if ($p->id) {

            $p->qty++;
            $p->save(false);
            return $p->id;
        } else {

            $or = new ProductItem();
            $or->order_id = $order_id;
            $or->product_id = $product_id;
            $or->variant_id = $variant_id;
            $or->price = Product::get_price($product_id,$number_fromat=FALSE,$currency=FALSE);
            $or->qty = 1;
            //        $or->chosen_color = $color;

            $or->save(false);

            //print_r($or->getErrors());

            return $or->id;
        }
        //}else{
        //    return -9; // برای پیغام
        //}
    }
}
