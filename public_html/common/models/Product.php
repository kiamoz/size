<?php

namespace common\models;

ini_set('gd.jpeg_ignore_warning', 1);

use Yii;
use common\models\Price;
use common\models\ProductHasCategory;
use yii\data\Pagination;
use common\models\ProductPrice;
use yii\helpers\ArrayHelper;

class Product extends \yii\db\ActiveRecord {

    public $file, $attrme, $attrc, $upload, $img1;
 
    public static function tableName() {
        return 'product';
    }

    public function rules() {
        return [
                [['name'], 'required'],
                [['extera_info','upload', 'default_variant', 'price_range', 'english_name', 'qty', 'link', 'variant_show_type'], 'safe'],
                [['slug', 'weight', 'gallery', 'status', 'barcode', 'summery', 'body', 'image', 'image2', 'code','file','order_show'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'شناسه',
            'date' => 'ترتیب نمایش',
            'weight' => 'وزن',
            'name' => 'نام ',
            'english_name' => 'نام لاتین',
            'image' => 'تصویر اول ',
            'img1' => 'تصویر اول ',
            'image_2' => 'تصویر دوم ',
            'file' => 'تصویر دوم ',
            'summery' => 'چکیده',
            'body' => 'توضیحات',
            'link' => 'لینک',
            'qty' => 'تعداد',
            'variant_show_type' => ' نوع نمایش variant',
            'default_variant' => ' Variant پیش فرض',
            'price_range' => 'محدوده قیمت',
            'gallery' => '',
            'status' => 'وضعیت',
            'barcode' => 'بارکد',
            'attrc' => 'دسته بندی ',
            'extera_info' => 'اطلاعات بیشتر',
            'code' => 'کد کالا',
        ];
    }

    public function getPrices() {
        return $this->hasMany(Price::className(), ['product_id' => 'id']);
    }

    public function getProductHasCategory() {
        return $this->hasMany(ProductHasCategory::className(), ['product_id' => 'id']);
    }

//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getAttGroup() {
//        return $this->hasOne(AttGroup::className(), ['id' => 'att_group_id']);
//    }
//
    public static function getProductCats($id) {

        $category_arr = array();
        $m = ProductHasCategory::find()
                ->with('product')
                ->where('product_id=' . $id)
                ->all();

        foreach ($m as $cats) {
            array_push($category_arr, $cats->product_category);
        }
        return $category_arr;
    }


    public static function get_related_product($id, $count) {
        if (!is_numeric($id)) {

            $id = Product::getProductId($id);

            if (!$id) {
                return $this->redirect(['site/index']);
            }
        }
        $rproduc = \common\models\ProductHasCategory::find()
                ->innerJoinWith('product')
                ->andWhere(['product_category' => Product::getProductCats($id)])
                ->limit($count)
                ->orderBy(['rand()' => SORT_DESC])
                ->all();
        return $rproduc;
    }
    
    
    
     public static function getCats($id) {




        if (Product::find()->where(['id' => $id])->exists()) {
            $category_arr = array();
            $m = ProductHasCategory::find()->
                            with('productCategory')->
                            where('product_id=' . $id)->all();
            foreach ($m as $cats) {
                array_push($category_arr, $cats->product_category);
            }
            return $category_arr;
        }
    }
    
    public static function getCategory_name($id) {

        $list = "";
        $arr = Product::getCats($id);

        foreach ($arr as $cats) {
            $list .= "-" . ProductCategory::getCategoryName($cats);
        }
        return $list;
    }
    
    

    

    public static function getRate($id) {

        $sumrate = 0;

        $r = ProductRate::find()
                ->where('product_id=' . $id)
                ->all();

        foreach ($r as $rr) {
            $sumrate += $rr->rate;
        }


        return $sumrate / 5;
        ;
    }

    public static function getSlug($title) {
        $title = str_replace('&#8204;', '*', $title);
        $title = str_replace('‌', '-', $title);
        $title = str_replace(' ً', '-', $title);
        $title = str_replace('ئٍ', '-', $title);
        $title = str_replace("ئ", "", $title);
        $title = str_replace('ُ', '', $title);
        $title = str_replace('ِ', '', $title);
        $title = str_replace('اً', '-', $title);
        $title = str_replace(' ', '-', $title);
        $title = str_replace('&zwnj;', '*', $title);
        $title = str_replace("\xE2\x80\x8B", "", $title);
        $title = str_replace(":", "", $title);
        $title = str_replace("»", "", $title);
        $title = str_replace('"', "", $title);
        $title = str_replace("«", "", $title);
        $title = str_replace(".", "", $title);
        $title = str_replace("!", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("،", "", $title);
        $title = str_replace("?", "", $title);
        $title = str_replace("(", "-", $title);
        $title = str_replace(")", "-", $title);
        $title = str_replace(" ", "-", $title);
        $title = str_replace("/", "-", $title);
        $title = str_replace("+", "-", $title);
        $title = str_replace("--", "-", $title);
        $title = str_replace("---", "-", $title);
        $title = str_replace("<br>", "-", $title);
        $title = str_replace("'", "-", $title);
        $title = str_replace(",", "-", $title);
        return $title;
    }

    public static function getProductId($slug) {

        return Product::find()->where('slug="' . $slug . '"')->One()->id;
    }

    public static function get_product_of_category_pagination($_category_id, $_count) {
        $_ret_array = array();
        $query = ProductHasCategory::find()
                ->innerJoinWith('product')
                ->where('product_category=' . $_category_id);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $_count]);


        $_data = $query->offset($pages->offset)
                ->limit($_count)
                ->all();
        $_ret_array = (['data' => $_data, 'pages' => $pages]);

        return $_ret_array;
    }

    public static function get_category_data($_cat_id) {
        return ProductCategory::findOne($_cat_id);
    }

    public static function getName($pid) {

        return Product::findOne($pid)->name;
    }

    public function getPricef() {
        return $this->hasOne(ProductPrice::className(), ['product_id' => 'id']) ->orderBy(['id'=>SORT_DESC]);
    }
    
    
   
    
    
    public static function get_price_v($id, $number_fomrat = TRUE, $show_currency = TRUE) {
        
        $last_price = ProductPrice::find()->where(['variant_id'=>$id])->orderBy(['id'=>SORT_DESC])->One()->selling_rate;
        if ($last_price) {
           
            
                if ($number_fomrat) {
                    $last_price = number_format($last_price);
                }
                if ($show_currency) {
                    $last_price .= " ریال";
                }
                return ($last_price);
            
        }
        
    }
    
    public static function get_price_v_buy($id) {

        $last_price = ProductPrice::find()->where(['variant_id'=>$id])->orderBy(['id'=>SORT_DESC])->One()->selling_rate;
        if ($last_price) {
            return $last_price;
        }
    }

    public static function get_price($id, $number_fomrat = TRUE, $show_currency = TRUE) {

        $last_price = Product::findone($id)->pricef->selling_rate;
        if (!$last_price) {
            return Product::findone($id)->extera_info;
        } else {
            if ($last_price) {
                if ($number_fomrat) {
                    $last_price = number_format($last_price);
                }
                if ($show_currency) {
                    $last_price .= " ریال";
                }
                return ($last_price);
            }
        }
    }
    public static function get_price_buy($id) {

        $last_price = Product::findone($id)->pricef->buying_rate;
        if ($last_price) {
            return $last_price;
        }
    }
    
    
    
    
    

    public static function get_cats_id_and_name($id) {
        if ($id) {
            $cats_name = array();
            $cats_id = array();
            $return_array = array();
            $product_cats = ProductHasCategory::find()
                            ->with('productCategory')
                            ->where('product_id=' . $id)->all();
            foreach ($product_cats as $product_cat) {

                $return_array[$product_cat->productCategory->id] = $product_cat->productCategory->name;
            }

            return $return_array;
        }
    }

}
