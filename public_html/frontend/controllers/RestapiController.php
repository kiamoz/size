<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use common\models\ProductCategory;
use common\models\ProductCategoryHasCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Post;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ProductHasCategory;
use common\models\Order;
use common\models\Orders;
use common\models\Item;
use common\models\ItemHasOrder;
use common\models\Comment;
use yii\data\Pagination;
use common\models\User;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class RestapiController extends Controller {

    public function beforeAction($action) {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        // if($action->id == 'payment_verify'  )
        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models. 
     * @return mixed
     */
    public function actionOrders($customer) {
        header('Content-Type: application/json');




        $order_to_show = Order::find()->where(['user_id' => $customer])->orderBy(['id' => SORT_DESC])->all();


        $big = array();




        foreach ($order_to_show as $order) {

            $temp = array();
            $temp['id'] = $order->id;
            $temp['number'] = $order->id;
            $temp['status'] = Order::status_text[$order->status];
            $temp['date_created'] = \common\models\Persian::convert_date_to_fa($order->date);  //     $product->product->summery; 

            $total = $order->price_final;
            if ($total > 0) {
                $total = number_format($total);
            }
            $temp['total'] = $total;

            $temp['line_items'] = [];
            $items = \common\models\ProductItem::find()->where(['order_id' => $order->id])->all();
            foreach ($items as $item) {

                $temp_2 = array();
                $temp_2['name'] = Product::findOne($item->product_id)->name;
                $temp_2['p_id'] = $item->product_id;
                $temp_2['quantity'] = $item->qty;
                $total = $item->qty * Product::get_price($item->product_id, FALSE, FALSE);
                if ($total > 0) {
                    $total = number_format($total);
                }
                $temp_2['total'] = $total;

                array_push($temp['line_items'], $temp_2);
            }



            array_push($big, $temp);
        }

        echo json_encode($big, JSON_UNESCAPED_UNICODE);




        $json = file_get_contents('http://size.ir/order.json');
        //echo $json;
    }

    public function generate_category_json_arr($cat_object, $parent_id) {

        $site_base = (dirname(dirname(dirname(__FILE__)))) . "/backend/web/";
        $temp = array();
        $temp['id'] = $cat_object->id;
        $temp['name'] = trim($cat_object->name);
        $temp['parent'] = $parent_id;



        $src = $site_base . $cat_object->img;

        $temp['image'] = ["src" => Post::resize_img($src, 650, 250, "_cat" . $cat_object->id . $cat_object->update_date)];
        //$temp['image'] = ["src" => "http://shidab.net/mstore-master/wordpress__/wp-content/uploads/2017/12/man.png"];

        $temp['count'] = ProductHasCategory::find()->where(['product_category' => $cat_object->id])->count();

        return $temp;
    }

    public function actionCategories($id = 0) {


        $post_to_show = ProductCategory::find()->where('is_mother=1')->all();








        $big = array();


        foreach ($post_to_show as $mother_cat) {





            array_push($big, $this->generate_category_json_arr($mother_cat, 0));



            $cats = ProductCategoryHasCategory::find()->with('productCategory')->where('parent_category=' . $mother_cat->id)->all();

            foreach ($cats as $child_cats) {

                array_push($big, $this->generate_category_json_arr($child_cats->productCategory, $mother_cat->id));
            }
        }


        header('Content-Type: application/json');
        echo json_encode($big, JSON_UNESCAPED_UNICODE);


        //$json = file_get_contents('http://size.ir/category.json');
        //echo $json;
    }

    public function actionGet_product($id = 0) {


        header('Content-Type: application/json');
        $json = file_get_contents('http://size.ir/download.json');
        echo $json;
    }

    public function actionProducts($category = 0) {



        //$category = 726;
        $cats = ProductHasCategory::find()->with('product');
        if ($category) {
            $cats->where('product_category=' . $category);
        }

        $countQuery = clone $cats;
        //$page_limit = \common\models\Sitesetting::findone(1)->pagination/2;
        $page_limit = 5;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $page_limit]);

        $post_to_show = $cats->offset($pages->offset)
                ->orderBy(['product_id' => SORT_DESC])
                ->limit($page_limit)
                ->all();

        $big = array();
        //echo count($post_to_show);
        $site_base = (dirname(dirname(dirname(__FILE__)))) . "/backend/web/";
        foreach ($post_to_show as $product) {

            $temp = array();
            $temp['id'] = $product->product->id;
            $temp['name'] = trim($product->product->name);
            $temp['description'] = ""; //    $product->product->body; 
            $temp['short_description'] = ""; //     $product->product->summery; 
            $temp['price'] = Product::get_price($product->product->id, FALSE, FALSE);
            $temp['regular_price'] = $temp['price'];
            $temp['sale_price'] = '0';
            $temp['in_stock'] = 'true';
            //$temp['on_sale'] =     'false';
            $temp['related_ids'] = [];
            $src = $site_base . $product->product->image;
            //$temp['images'] =   [[ "src" => "http://size.ir/frontend/web/upload3/_px__22122018-06-30%2010:23:42600550m.jpg"]];
            $temp['images'] = [["src" => Post::resize_img($src, 1000, 1499, "_" . $product->product->id . $product->product->date)]];

            $m = explode("\n", $product->product->gallery);
            $items_arr = array();
            $i = 1;
            foreach ($m as $imgx) {

                if ($imgx == "") {
                    continue;
                }
                $tmp = array();

                $url_ = parse_url(trim($imgx));
                $tmp['src'] = Post::resize_img((dirname(dirname(dirname(__FILE__)))) . $url_['path'], 1000, 1499, "_" . $i . $product->product->id);

                array_push($temp['images'], $tmp);
                $i++;
            }

            $temp['attributes'] = [
                    ['name' => 'color', 'options' => ['red', 'blue', 'black']],
                    ['name' => 'size', 'options' => ['S', 'M', 'L']],
                    ['name' => 'وزن', 'options' => ['iiiii', 'M', 'L']]
            ];

            $temp['default_attributes'] = [];

            array_push($big, $temp);
        }






        //header('Content-Type: application/json');
        //$json = file_get_contents('http://size.ir/download_1.json');

        echo json_encode($big, JSON_UNESCAPED_UNICODE);




        //echo $json;
    }

    /*
      function json_response( $code = 200,$message = null)
      {
      // clear the old headers
      header_remove();
      // set the actual code
      http_response_code($code);
      // set the header to make sure cache is forced
      header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
      // treat this as json
      header('Content-Type: application/json');
      $status = array(
      200 => '200 OK',
      400 => '400 Bad Request',
      422 => 'Unprocessable Entity',
      500 => '500 Internal Server Error'
      );
      // ok, validation error, or failure
      header('Status: '.$status[$code]);
      // return the encoded json
      return json_encode(array(
      'status' => $code < 300, // success or not?
      'message' => $message
      ));
      } */

    public function actionOrders4() {
        header('Content-Type: application/json');
        file_put_contents('ret/test.txt', file_get_contents('php://input'));




        $json = file_get_contents('php://input');

        $obj = json_decode($json, true);






        $arr = json_decode($obj['payload'], true);

        $order = Order::add_new_order(TRUE, $arr['customer_id']);
        $address = new \common\models\Address();
        $address->address = $arr['shipping']['address_1'];
        $address->cell_number = $arr['billing']['phone'];
        $address->postal_code = $arr['billing']['postcode'];
        $address->user_id = $arr['customer_id'];


        $address->save();

        $order->address_id = $address->id;
        foreach ($arr['line_items'] as $item) {
            $order->add_to_card($item['product_id'], $item['quantity'], $order);
        }


        if ($arr['payment_method'] != "bacs") {
            $order->status = 2;
        } else {
            $order->status = 1;
        }



        $order->price_final = Order::cal_total($order->id);
        $order->save();









// Converting the message into JSON format.
        $json = json_encode($order->id);

// Echo the message.
        echo $json;
    }

    public function actionOrders3() {








        // Getting the received JSON into $json variable.
        $json = file_get_contents('php://input');

        // decoding the received JSON and store into $obj variable.
        $obj = json_decode($json, true);




        // If the record inserted successfully then show the message.
        $MSG = $obj['id'];
        $arr = json_decode($obj['id'], true);

        $order = Order::add_new_order(TRUE, $arr['customer_id']);
        $address = new \common\models\Address();
        $address->address = $arr['shipping']['address_1'];
        $address->cell_number = $arr['billing']['phone'];
        $address->postal_code = $arr['billing']['postcode'];
        $address->user_id = $arr['customer_id'];


        $address->save();

        $order->address_id = $address->id;
        foreach ($arr['line_items'] as $item) {
            $order->add_to_card($item['product_id'], $item['quantity'], $order);
        }


        if ($arr['payment_method'] != "bacs") {
            $order->status = 2;
        } else {
            $order->status = 1;
        }



        $order->price_final = Order::cal_total($order->id);
        $order->save();









// Converting the message into JSON format.
        $json = json_encode($order->id);

// Echo the message.
        echo $json;
    }

    public function actionOrders2() {



        /*
          $json_string = json_encode($_POST);

          $file_handle = fopen('my_filename.json', 'w');
          fwrite($file_handle, $json_string);
          fclose($file_handle);


          file_put_contents('test.txt', file_get_contents('php://input'));

         */
        header('Content-Type: application/json');
        $data_posts = array('id' => 123213, 'body' => 'fff');
        echo json_encode($data_posts, JSON_UNESCAPED_UNICODE);
    }

    public function actionLogin() {

        $ret = array();
        $json = file_get_contents('php://input');
        $__post = json_decode($json, true);

        //file_put_contents('p.txt', $__post['password']);
        //file_put_contents('u.txt', $__post['username']);
        //$ret['status'] = -1;
        //$ret['user_id'] = "hh";


        if ($__post['username'] and $__post['password']) {
            $hash = User::find()->where(['username' => $__post['username']])->One();


            if (Yii::$app->getSecurity()->validatePassword($__post['password'], $hash->password_hash)) {
                $ret['status'] = 1;
                $ret['user_id'] = $hash->id;
            }
        } else {
           $ret['status'] = -1;
        }


        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionRegister() {


        $user = new User();
        $code = rand(1000, 9999);

        $json = file_get_contents('php://input');
        $__post = json_decode($json, true);



        $user->username = $__post['username'];
        $user->code = $code;
        $user->status = -1;

        $ret = array();

        if ($user->save()) {

            $send = new \sendAPI('lopen', '1qaz!QAZ');
            $mobiles = array($user->username);
            $body = 'سلام ';
            $body .= 'کد فعال سازی   : ';

            //$body.='برای شما ثبت شد. ';
            $body .= $code;
            $result = $send->send($mobiles, $body);




            $ret['user_id'] = $user->id;
            $ret['status'] = 1;
            $ret['msg'] = "OK";
            $ret['cookie'] = $user->username . "|2178t7gbsajhdsad|" . $user->id;
        } else {

            $ret['msg'] = 'این شماره قبلا ثبت شده است';
            $ret['status'] = -1;
        }


        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionRegister_step_2() {




        $json = file_get_contents('php://input');
        $__post = json_decode($json, true);



        $user_object = User::findOne($__post['user_id']);
        if ($user_object->code == $__post['user_code']) {

            $user_object->status = 0;
            $user_object->save();
            $ret['user_id'] = $user_object->id;
            $ret['status'] = 1;
            $ret['msg'] = "OK";
        } else {
            $ret['user_id'] = $user_object->id;
            $ret['status'] = -1;
            $ret['msg'] = "کد ارسال شده اشتباه است";
        }




        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionRegister_step_3() {
        $json = file_get_contents('php://input');
        $__post = json_decode($json, true);



        $user_object = User::findOne($__post['user_id']);

        $user_object->status = 10;
        $user_object->name_and_fam = $__post['name'];
        $user_object->email = $__post['email'];
        $user_object->setPassword($__post['password']);
        $user_object->generateAuthKey();
        $user_object->save();

        $ret['user_id'] = $user_object->id;
        $ret['status'] = 1;
        $ret['cookie'] = $user_object->username . "|2178t7gbsajhdsad|" . $user_object->id;
        $ret['msg'] = "ثبت نام تکمیل شد و حساب کاربری فعال شد";

        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionCustomers($id) {


        $user = User::findOne($id);



        $ret = array();
        $ret['id'] = $user->id;
        $ret['email'] = $user->email;
        $ret['code'] = $user->code;
        $ret['first_name'] = $user->name_and_fam;

        $ret['username'] = $user->username;
        $ret['shipping'] = [
            'first_name' => $user->name_and_fam,
            'last_name' => $user->name_and_fam,
            'company' => $user->name_and_fam,
            'address_1' => "",
            'city' => "",
            'postcode' => "",
            'email' => "",
            'phone' => "",
        ];
        $ret['avatar_url'] = "http://2.gravatar.com/avatar/868c53f52be54fca17b4395331513054?s=96&d=mm&r=g";


        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionGet_categories($id = 0) {


        header('Content-Type: application/json');
        $json = file_get_contents('http://size.ir/categories.json');
        echo $json;
    }

    public function actionBank_redirect($order_id) {
        
    }

    public function actionPayment_gateways() {

        header('Content-Type: application/json');
        $json = '[{
        "id": "bacs",
        "title": "d2",
        "description": "\u067e\u0631\u062f\u0627\u062e\u062a \u0622\u0646\u0644\u0627\u06cc\u0646 \u062a\u0648\u0633\u0637  \u06a9\u0644\u06cc\u0647 \u06a9\u0627\u0631\u062a \u0647\u0627\u06cc \u0639\u0636\u0648 \u0634\u0628\u06a9\u0647 \u0634\u062a\u0627\u0628",
        "order": 0,
        "enabled": true,
        "method_title": "BACS",
        "method_description": "Allows payments by BACS, more commonly known as direct bank\/wire transfer.",
        "settings": {
            "title": {
                "id": "title",
                "label": "Title",
                "description": "This controls the title which the user sees during checkout.",
                "type": "text",
                "value": "\u067e\u0631\u062f\u0627\u062e\u062a \u0622\u0646\u0644\u0627\u06cc\u0646 \u0628\u0627\u0646\u06a9 \u0645\u0644\u062a",
                "default": "Direct bank transfer",
                "tip": "This controls the title which the user sees during checkout.",
                "placeholder": ""
            },
            "instructions": {
                "id": "instructions",
                "label": "Instructions",
                "description": "Instructions that will be added to the thank you page and emails.",
                "type": "textarea",
                "value": "",
                "default": "",
                "tip": "Instructions that will be added to the thank you page and emails.",
                "placeholder": ""
            }
        },
        "_links": {
            "self": [{
                    "href": "http:\/\/shidab.net\/mstore-master\/wordpress__\/wp-json\/wc\/v2\/payment_gateways\/bacs"
                }],
            "collection": [{
                    "href": "http:\/\/shidab.net\/mstore-master\/wordpress__\/wp-json\/wc\/v2\/payment_gateways"
                }]
        }
    }, {
        "id": "cod",
        "title": "d1",
        "description": "\u0628\u0627 \u0627\u06cc\u0646 \u0631\u0648\u0634 \u0648\u062c\u0647 \u0631\u0627 \u062f\u0631\u0628 \u0645\u0646\u0632\u0644 \u062e\u0648\u062f \u0628\u0647 \u0645\u0627\u0645\u0648\u0631  \u0627\u0631\u0633\u0627\u0644 \u0633\u0627\u06cc\u0632 \u067e\u0631\u062f\u0627\u062e\u062a \u06a9\u0631\u062f\u0647",
        "order": 1,
        "enabled": true,
        "method_title": "Cash on delivery",
        "method_description": "Have your customers pay with cash (or by other means) upon delivery.",
        "settings": {
            "title": {
                "id": "title",
                "label": "Title",
                "description": "Payment method description that the customer will see on your checkout.",
                "type": "text",
                "value": "\u067e\u0631\u062f\u0627\u062e\u062a \u062f\u0631 \u0645\u062d\u0644",
                "default": "Cash on delivery",
                "tip": "Payment method description that the customer will see on your checkout.",
                "placeholder": ""
            },
            "instructions": {
                "id": "instructions",
                "label": "Instructions",
                "description": "Instructions that will be added to the thank you page.",
                "type": "textarea",
                "value": "\u0628\u0627 \u0627\u06cc\u0646 \u0631\u0648\u0634 \u0648\u062c\u0647 \u0631\u0627 \u062f\u0631\u0628 \u0645\u0646\u0632\u0644 \u062e\u0648\u062f \u0628\u0647 \u0645\u0627\u0645\u0648\u0631  \u0627\u0631\u0633\u0627\u0644 \u0633\u0627\u06cc\u0632 \u067e\u0631\u062f\u0627\u062e\u062a \u06a9\u0631\u062f\u0647",
                "default": "Pay with cash upon delivery.",
                "tip": "Instructions that will be added to the thank you page.",
                "placeholder": ""
            },
            "enable_for_methods": {
                "id": "enable_for_methods",
                "label": "Enable for shipping methods",
                "description": "If COD is only available for certain methods, set it up here. Leave blank to enable for all methods.",
                "type": "multiselect",
                "value": "",
                "default": "",
                "tip": "If COD is only available for certain methods, set it up here. Leave blank to enable for all methods.",
                "placeholder": "",
                "options": {
                    "flat_rate": "Flat rate",
                    "free_shipping": "Free shipping",
                    "local_pickup": "Local pickup"
                }
            },
            "enable_for_virtual": {
                "id": "enable_for_virtual",
                "label": "Accept COD if the order is virtual",
                "description": "",
                "type": "checkbox",
                "value": "yes",
                "default": "yes",
                "tip": "",
                "placeholder": ""
            }
        },
        "_links": {
            "self": [{
                    "href": "http:\/\/shidab.net\/mstore-master\/wordpress__\/wp-json\/wc\/v2\/payment_gateways\/cod"
                }],
            "collection": [{
                    "href": "http:\/\/shidab.net\/mstore-master\/wordpress__\/wp-json\/wc\/v2\/payment_gateways"
                }]
        }
    
    }]';




        echo $json;
    }

}
