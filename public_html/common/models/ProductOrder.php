<?php

namespace common\models;

use common\models\ShippingHasLocation;
use common\models\CreditTransition;

require(__DIR__ . '/../../date.php');
$site_base = dirname(dirname(dirname(dirname(__FILE__))));

use Yii;
use yii\helpers\Url;

class ProductOrder extends \yii\db\ActiveRecord {

    public $date_farsi;
    public $cdate_farsi;

    const status_text = array(
        0 => 'معلق',
        1 => 'پرداخت نشده',
        2 => 'پرداخت در محل',
        3 => 'پرداخت شده',
        4 => ' درحال بررسی',
        5 => 'ارسال شده',
        6 => 'تحویل داده شده',
        7 => 'استرداد شده',
        8 => 'لغو شده'
    );
    const payment = array(
        0 => 'آنلاین',
        1 => 'نقدی',
        2 => 'پوز',
    );

    public static function tableName() {
        return 'product_order';
    }

    public static function get_site_protocol() {
        return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
    }

    public function rules() {
        return [
                [['status', 'shipping_method_id', 'user_id', 'uniq_id', 'update_date', 'address_id',
            'price', 'price_after_discount', 'price_shipping', 'price_final', 'payment_id',
            'wire_transfer', 'shop_location_id', 'description', 'pay_status','payment_method_id'], 'safe'],
                [['address_id'], 'required', 'on' => 'check_address'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'شماره سفارش',
            'address_id' => "آدرس",
        ];
    } 

    public function getOrderHasItems() {
        return $this->hasMany(OrderHasItem::className(), ['order_id' => 'id']);
    }

    public static function add_to_card($product_id, $qty,$order_object=null) {


        if(!$order_object){
        $order = \common\models\Order::check_order();
        }else{
         $order = $order_object->id; 
        }
        
        
        if ($order) {
            $order_id = $order;
        } else {
            $order_id = \common\models\Order::add_new_order();
        }

        for ($i = 0; $i < $qty; $i++) {
            $m2 = ProductItem::add_new_item_to_order($order_id, $product_id);
        }
        $count = \common\models\Order::get_order_count();
        $arr = array();
        $arr['flag'] = 1;
        $arr['count'] = \common\models\Post::arabic_w2e($count);
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    static public function get_order_count() {



        $order_id = ProductOrder::check_order();
        //echo $order_id;
        // exit();
        if ($order_id != 0) {

            $p = ProductItem::find()
                    ->where('order_id = ' . $order_id)
                    ->all();

            $total = 0;
            foreach ($p as $pp) {
                $total += $pp->qty;
            }
            return $total;
        } else {
            return 0;
        }
    }

    static public function update_item_qty($item_id, $qty) {

        $item = ProductItem::findOne($item_id);
        $item->qty = $qty;
        $item->save(FALSE);
        //echo "done";
    }

    static public function cal_ship_price($method) {

        $has_id = ProductOrder::check_order();
//echo $has_id."*";
        if ($has_id) {
            $order_id = $has_id;
            $total = 0;
            $items = ProductItem::find()->where('order_id=' . $order_id)->all();
            $order = ProductOrder::findOne($order_id);


            $total += $ship->price;
            $total_weight = 0;
            foreach ($items as $item) {
                $total_weight += (Product::findOne($item->product_id)->weight) * $item->qty;
                $total += (Product::get_price($item->product_id) * $item->qty);
            }
            //echo $total;
        }



        $price = ShippingHasLocation::find()->where('location_id=' . \Yii::$app->user->identity->location . " and shipping_id=" . $method)->One()->price;
        $price1 = ShippingHasLocation::find()->where('location_id=' . \Yii::$app->user->identity->location . " and shipping_id=" . $method)->One()->extra_price;

        //echo $price."/".$price1;

        if ($method == 5) {

            if ($total_weight < 2001) {
                $totalx = $price;
            } else {
                $totalx = ($price) + ($price1 * (($total_weight - 2000) / 1000));
            }
        }

        if ($method == 6) {

            if ($total_weight < 6001) {
                $totalx = $price;
            } else {
                $totalx = ($price) + ($price1 * (($total_weight - 6000) / 1000));
            }
        }
        return $totalx;
    }
    
    static public function cal_total($order_id){
        
          if ($order_id) {

            $total = 0;
            $items = ProductItem::find()->where('order_id=' . $order_id)->all();
            foreach ($items as $item) {

                $total += (Product::get_price($item->product_id,FALSE,FALSE) * $item->qty);
            }
            return $total;
            
          }
    }

    static public function submit_order($method = 0, $free_send = 0) {

        $order_id = ProductOrder::check_order();
        if ($order_id) {

            $total = 0;
            $items = ProductItem::find()->where('order_id=' . $order_id)->all();
            foreach ($items as $item) {

                $total += (Product::get_price($item->product_id,FALSE,FALSE) * $item->qty);
            }

            if (!($free_send == 6)) {
                $totalx = ProductOrder::cal_ship_price($method);
                $total += $totalx;
            }
            //$total+=$peyk;


            $order = ProductOrder::find()->where('id=' . $order_id)->one();

            $order->price = $total;
            if ($free_send == 3) {
                $order->status = 3;
            } else {
                $order->status = 1;
            }

            $order->ship_method = $method;
            $order->save(false);

            return $order_id;
        }
    }

//    public function afterFind()
//    {
//         parent::afterFind();
//         
//         
//       $dd =  $this->date;
//        $pieces_time = explode(" ", $dd);
//        
//        $pieces = explode("-", $dd);
//        $exdate = gregorian_to_jalali($pieces[0],$pieces[1],$pieces[2]);
// 
//       // $this->$date_farsi  = $pieces_time[1]." ".$exdate[0]."/".$exdate[1]."/".$exdate[2];
//        $this->date_farsi  = $exdate[0]."/".$exdate[1]."/".$exdate[2];
//       
//    } 


    static public function UniqueMachineID($salt = "") {

        return md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $temp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "diskpartscript.txt";
            if (!file_exists($temp) && !is_file($temp))
                file_put_contents($temp, "select disk 0\ndetail disk");
            $output = shell_exec("diskpart /s " . $temp);
            $lines = explode("\n", $output);
            $result = array_filter($lines, function($line) {
                return stripos($line, "ID:") !== false;
            });
            if (count($result) > 0) {
                $result = array_shift(array_values($result));
                $result = explode(":", $result);
                $result = trim(end($result));
            } else
                $result = $output;
        } else {
            $result = shell_exec("blkid -o value -s UUID");
            if (stripos($result, "blkid") !== false) {
                $result = $_SERVER['HTTP_HOST'];
            }
        }
        return md5($salt . md5($result));
    }

    public static function cal_order_sum() {



        $order_id = ProductOrder::check_order(0, TRUE);
        if ($order_id->id) {
            $_items = ProductItem::find()
                    ->where('order_id=' . $order_id->id)
                    ->all();
            $order_id->price = 0;
            if ($_items) {
                foreach ($_items as $_item) {
                    $order_id->price += (Product::get_price($_item->product_id,FALSE,FALSE) * $_item->qty);
                }
            }

           
            $order_id->save();

            return $order_id;
        }
    }

    static public function check_order($status = 0, $_get_object = FALSE) {


        $uniq_id = ProductOrder::UniqueMachineID();
        //$uniq_id=$_SERVER['REMOTE_ADDR'] ;
        if (!\Yii::$app->user->identity->id) {

            $p = ProductOrder::find()
                    ->where('uniq_id="' . $uniq_id . '" and status = ' . $status)
                    ->orderBy(['id' => SORT_DESC])
                    ->one();
        } else {
            $p = ProductOrder::find()
                    ->where('user_id=' . \Yii::$app->user->identity->id . " and status = " . $status)
                    ->orderBy(['id' => SORT_DESC])
                    ->one();
        }

        if ($_get_object) {
            return $p;
        } else {
            return $p->id;
            ;
        }
    }

    static public function add_new_order($get_object = false,$user_id=0) {

        
        
        if(!$user_id){
           $user_id =  \Yii::$app->user->identity->id;
        }
        if ($user_id) {
            $or = new ProductOrder();
            $or->user_id = $user_id;
            $or->status = 0;
            $or->save(false);
            if ($get_object) {
                return $or;
            }
            return $or->id;
        } else {
            $or = new ProductOrder();
            $or->uniq_id = ProductOrder::UniqueMachineID();
            //$or->uniq_id = $_SERVER['REMOTE_ADDR'] ;
            $or->status = 0;
            $or->save(false);
            if ($get_object) {
                return $or;
            }
            return $or->id;
        }
    }

    static public function remove_item($item_id) {

        $order_id = ProductItem::findOne($item_id);
        $order_id->delete();
    }

//       static  public function  removeitem($item_id){ Site controller
//          
//          $order_id = ProductItem::findOne($item_id);
//          $order_id->delete();
//
//          
//          
//      }




    public static function getStatus($status) {
        $st = 'معلق';

        switch ($status) {
            case 0:
                $st = "معلق";
                break;
            case 1:

                $st = "معلق(شامل تخفیف)";
                break;
            case 2:

                $st = "  کارت(بدون فیش)";
                break;
            case 5:

                $st = "پرداخت شده";
                break;
            case 30:

                $st = "پرداخت شده";
                break;
            case 6:
                $st = "ثبت فیش بدون تایید ";
                break;
            case 7:
                $st = "عدم تایید فیش";
                break;
            case 15:
                $st = "انصراف";
                break;

            case 25:
                $st = "پرداخت+نماینده";
            case 21:
                $st = "در حال آماده سازی";
                break;

            case 22:
                $st = "ارسال شد";
        }
        return $st;
    }

    public function afterFind() {
        parent::afterFind();

        $cd = date("Y-m-d");

        $cpieces_time = explode(" ", $cd);
        $cpieces = explode("-", $cd);
        $cexdate = gregorian_to_jalali($cpieces[0], $cpieces[1], $cpieces[2]);
        $dd = $this->date;
        $pieces_time = explode(" ", $dd);

        $pieces = explode("-", $dd);
        $exdate = gregorian_to_jalali($pieces[0], $pieces[1], $pieces[2]);

        // $this->$date_farsi  = $pieces_time[1]." ".$exdate[0]."/".$exdate[1]."/".$exdate[2];
        $this->date_farsi = $exdate[0] . "/" . $exdate[1] . "/" . $exdate[2];
        $this->cdate_farsi = $cexdate[0] . "/" . $cexdate[1] . "/" . $cexdate[2];
    }

    public static function getStatususer($status) {
        $st = 'معلق';

        switch ($status) {
            case 0:
                $st = "معلق";
                break;
            case 1:

                $st = "معلق(شامل تخفیف)";
                break;
            case 2:

                $st = "کارت به کارت(بدون فیش)";
                break;
            case 5:

                $st = " قطعی";
                break;
            case 6:
                $st = "در انتظار تایید فیش ";
                break;
            case 7:
                $st = "عدم تایید فیش";
                break;
            case 15:
                $st = "انصراف";
                break;
        }
        return $st;
    }

    public static function Getshipmethod($status) {
        $st = 'معلق';

        switch ($status) {
            case 0:
                $st = "معلق";
                break;
            case 1:

                $st = "پیشتاز";
                break;
            case 2:

                $st = "کارت به کارت(بدون فیش)";
                break;
            case 5:

                $st = " قطعی";
                break;
            case 6:
                $st = "در انتظار تایید فیش ";
                break;
            case 7:
                $st = "عدم تایید فیش";
                break;
            case 15:
                $st = "انصراف";
                break;
        }
        return $st;
    }

    public static function Get_raveshe_ersal($status) {
        $st = 'بدون روش';

        switch ($status) {
            case 32:
                $st = "پیک موتوری";
                break;
            case 6:

                $st = "سفارشی";
                break;
            case 1:

                $st = "پیشتاز";
                break;
            case 0:

                $st = "-";
                break;
        }
        return $st;
    }

    public static function get_cart_items() {
        $_has_order = ProductOrder::check_order();
        if ($_has_order) {
            $_order_items = ProductItem::find()
                    ->where('order_id=' . $_has_order)
                    ->all();
            return $_order_items;
        }
    }

    public static function get_Shipping_method_price($shipmethod, $save = 0) {

        
        
        $_order = ProductOrder::check_order(0, TRUE);
        //echo $_order->id;
        $_city_id = ProductAddress::findOne($_order->address_id)->city_id;
        //echo $_city_id;


        $_hazine = ShippingHasLocation::find()
                ->where('shipping_id=' . $shipmethod)
                ->andWhere('location_id=' . $_city_id)
                ->one();

        if ($save) {

            $_order->shipping_method_id = $shipmethod;
            $_order->price_shipping = $_hazine->price;
            $_order->price_final = $_order->price + $_hazine->price;
            $_order->save();
        }


        $ret = array(
            'hazine_haml' => Post::arabic_w2e(number_format($_hazine->price)),
            'total_price' => Post::arabic_w2e(number_format($_order->price + $_hazine->price)),
            'order_price' => Post::arabic_w2e(number_format($_order->price)),
        );


        if ($_order->price > 0) {
            $ret['flag'] = 1;
        }

        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public static function get_shipping_methods() {
        $_ship_m = shipping_method::find()
                ->where('visibility=0')
                ->all();

        return $_ship_m;
    }

    public function getAddress() {
        return $this->hasOne(ProductAddress::className(), ['id' => 'address_id']);
    }

    public static function guest_order() {
        $current_guest_user_order = ProductOrder::findOne(['uniq_id' => ProductOrder::UniqueMachineID()]);


        $current_loged_in_user_order = ProductOrder::findOne(['user_id' => yii::$app->user->identity->id]);



        if ($current_guest_user_order->id and ! $current_loged_in_user_order->id) {
            $current_loged_in_user_order = ProductOrder::add_new_order(TRUE);
        }

        if ($current_guest_user_order->id) {


            $items = \common\models\ProductItem::find()->where('order_id=' . $current_guest_user_order->id)->all();

            foreach ($items as $item) {
                // echo "<br>".$item->id."<br>";
                // echo $item->product_id . "*<br>";
                $item->order_id = $current_loged_in_user_order->id;
                $item->save();
            }
            $current_guest_user_order->delete();
        }
    }

}
