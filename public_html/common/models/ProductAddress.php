<?php

namespace common\models;

use Yii;

class ProductAddress extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'product_address';
    }
    public function rules() {
         return [
            [['user_id', 'address', 'description', 'city_id',
                'state_id', 'cell_number', 'postal_code','name_and_fam'], 'safe'],
            [['user_id', 'city_id', 'state_id'], 'integer'],
            [['address', 'description'], 'string'],
            [['cell_number'], 'match', 'pattern' => '/09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{7,7}$/'],
            [['postal_code'], 'match', 'pattern' => '/[0-9]{10,10}$/'],
            //[['city_id','cell_number','address','name_and_fam'], 'required'],
            ['address', 'filled_some'],
        ];
    }
    public function attributeLabels() {
        return [
              'id' => 'شناسه',
            'user_id' => 'شناسه کاربر',
            'address' => 'آدرس پستی',
            'description' => 'توضیحات',
            'state_id' => 'استان (الزامی)',
            'city_id' => 'شهر',
            'name_and_fam' => 'نام و نام خانوادگی ',
            'cell_number' => 'شماره تلفن همراه',
            'postal_code' => 'کد پستی',
        ];
    }

    static public function get_city_name($id) {
        $_c_name = location::findOne($id);
        
        return $_c_name->name;
    }
    public static function get_location_from_state_id($id){
        
    }
    
    
    public function filled_some($attribute, $params) {

        if (empty($this->address) || empty($this->cell_number) || empty($this->name_and_fam)) {
            $this->addError('address', 'لطفا فیلد های آدرس را کامل  پر کنید');
        }
    }

}
