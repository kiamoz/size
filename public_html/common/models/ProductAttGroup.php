<?php

namespace common\models;

use Yii;

class ProductAttGroup extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'product_att_group';
    }

    public function rules() {
        return [
            [['name'], 'required'],
            
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
        ];
    }
    public function getAttGroupHasAtts() {
        return $this->hasMany(AttGroupHasAtt::className(), ['att_group_id' => 'id']);
    }
    public function getAtts() {
        return $this->hasMany(Att::className(), ['id' => 'att_id'])->viaTable('att_group_has_att', ['att_group_id' => 'id']);
    }
    public function getProducts() {
        return $this->hasMany(Product::className(), ['att_group_id' => 'id']);
    }

    public static function get_attg_name($id) {

        $p = AttGroup::find()->where('id=' . $id)->one();
        return $p->name;
    }

}
