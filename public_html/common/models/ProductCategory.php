<?php

namespace common\models;
use yii\helpers\Url; 
use Yii;

class ProductCategory extends \yii\db\ActiveRecord
{
    
         public $file,$att_group_id;
    public static function tableName()
    {
        return 'product_category';
    }

    
    public function rules()
    {
        return [
            [['name'], 'required'],
           
	    [['file','url','parent_id','img','slug','order_show','is_mother','menu_show','att_group_id'], 'safe'],
	    [['file'],'file'],
            [['name'], 'string', 'max' => 200]
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'name' => 'نام',
            'parent_id' => 'دسته اصلی',
            'url' => 'لینک',
            'attrchc'=>'دسته بندی مشترک',
            'att_set_id'=>'پکیج',
            'order_show'=>'ترتیب نمایش',
            'is_mother'=>' دسته بندی اصلی',
            'is_brand'=>' برند',
            'menu_show'=>'نمایش در منو',
            'is_mother'=>'دسته مادر-نمایش در اپ'
            
        ];
    }

    public function getProductHasCategories()
    {
        return $this->hasMany(ProductHasCategory::className(), ['product_category' => 'id']);
    }
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_has_category', ['product_category' => 'id']);
    }
    
    public static function get_upper($id){
        
        $count = CategoryHasCategory::find()->where('parent_category='.$id)->count();
        if($count!=0){
              // get_upper
        }
        
    }
    
    
    public static function breadcrumb($id,$arr=array(),$arr_id=array()){
        
        
        
         array_push($arr, ProductCategory::findOne($id)->name);
         array_push($arr_id, $id);
         //echo $ret;
         $cat = CategoryHasCategory::find()->where('category='.$id)->all();
         //echo "befor foreach <br>";
         foreach($cat as $child){
            //echo "get_root_id(".$child->parent_category.")<br>";
            return ProductCategory::breadcrumb($child->parent_category,$arr,$arr_id);
            //echo $child->parent_category."<br>";
         }
         $arr=  array_reverse($arr);
         $arr_id=  array_reverse($arr_id);
         $i=0;
         foreach($arr as $cats){
             $exp.= "<a href='".url::to(['product/all-cats'])."/".ProductCategory::findOne($arr_id[$i])->slug."'>".$cats."</a> <span style='font-family:tahoma !important'>»</span> ";
             $i++;
         }
         echo rtrim($exp,"»");
         
        
    }
    
    public static function get_root_id_level($id,$i=0){
         //echo "start(".$id.")<br>";
         //echo "count::".CategoryHasCategory::find()->where('category='.$id)->count();
         $cat = CategoryHasCategory::find()->where('category='.$id)->all();
         //echo "befor foreach <br>";
        
         foreach($cat as $child){
            $i++; 
            //echo "get_root_id(".$child->parent_category.")<br>";
            return ProductCategory::get_root_id_level($child->parent_category,$i);
            //echo $child->parent_category."<br>";
         }
         return  $i;
        
        
        
    }
    
    public static function get_root_id($id){
         //echo "start(".$id.")<br>";
         //echo "count::".CategoryHasCategory::find()->where('category='.$id)->count();
         $cat = CategoryHasCategory::find()->where('category='.$id)->all();
         //echo "befor foreach <br>";
         foreach($cat as $child){
            //echo "get_root_id(".$child->parent_category.")<br>";
            return ProductCategory::get_root_id($child->parent_category);
            //echo $child->parent_category."<br>";
         }
         return  $id;
        
        
        
    }
    
    public static function hasCHild($id){
        
         return CategoryHasCategory::find()
                  ->where('parent_category = '.$id)->count();
        
        
    }
    
    public static function getProductCount($id){
        
         return ProductHasCategory::find()
                ->where('product_category = '.$id)->count();
        
        
    }
    
    
    public static function  getCategoryName($id){
        return ProductCategory::findOne($id)->name;
    }
    public static  function  getProducCategorytId($slug)
{
        
        return ProductCategory::find()->where('slug="'.$slug.'"')->One()->id;
            
}
public static  function  getSlug($title)
{
         
            $title = str_replace(":","", $title);
            $title = str_replace("»","", $title);
            $title = str_replace('"',"", $title);
            $title = str_replace("«","", $title);
            $title = str_replace(".","", $title);
            $title = str_replace("!","", $title);
            $title = str_replace("؟","", $title);
            $title = str_replace("،","", $title);
            $title = str_replace("?","", $title);
            $title = str_replace(" ","-", $title);
            $title = str_replace("/","-", $title);
            $title = str_replace("+","-", $title);
            $title = str_replace("--","-", $title);
            $title = str_replace("---","-", $title);
            return $title;
         
     }
     public static function getProductCategoryId($slug) {

        return ProductCategory::find()->where('slug="' . $slug . '"')->One()->id;
    }
}
