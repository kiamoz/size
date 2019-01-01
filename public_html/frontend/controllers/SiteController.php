<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\ProductOrder;
use common\models\Post;
use yii\data\Pagination;
use common\models\Address;
use common\models\CreditTransition;
use common\models\ProductAddress;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
//                [
//                'class' => 'yii\filters\PageCache',
//                // 'keyPrefix' => 'news24news',
//                'only' => ['index2'],
//                'duration' => 300,
//            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                        [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                        [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'logout' => ['post'],
                ],
            ],
        ];
    }

    
      public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        if($action->id == 'payment_verify'  )
            $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }
    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        
              
       

        return $this->render('index');
    }

    public function actionColor() {

       return $this->render('color');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(['site/index']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    public function actionMenu() {
        return $this->render('menu');
    }

    public function actionSub_menu() {
        return $this->render('sub_menu');
    }

    public function actionNearestBranch($lat, $lng) {


        $all_des = array();
        foreach (\common\models\Branch::find()->all() as $branch) {



            $all_des[$branch->id] = \common\models\Branch::Getdistance($lat, $lng, $branch->lat, $branch->long, "K");
        }

        $near_id = array_keys($all_des, min($all_des))[0];
        $branch = \common\models\Branch::findOne($near_id);

        $ret = array();
        $ret['flag'] = 1;
        $ret['nearest'] = $branch->name;
        $ret['nearest_id'] = $near_id;
        $ret['distance'] = floor(min($all_des) * 100) / 100;


        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionMenuCat() {
        $menu_cat = array();
        foreach (\common\models\ItemCategory::find()->orderBy(['order_show' => SORT_ASC])->all() as $itemcat) {
            $menu_cat[$itemcat->id] = $itemcat->name;
        }

        $ret = array();
        $ret = $menu_cat;




        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionMenuItem($txt) {
        $site_base = dirname(dirname(dirname(__FILE__)));
        $menu_cat = array();
        // echo substr($txt, 8);
        $id = \common\models\ItemCategory::find()->where('name="' . trim(substr($txt, 8)) . '"')->One()->id;

        $img = \common\models\ItemCategory::find()->where('name="' . trim(substr($txt, 8)) . '"')->One()->img;

        if ($img) {
            $retimg = \common\models\ItemCategory::resize_img($site_base . '/backend/web/' . $img, 300, 200, "_" . $id);
        }
        //exit();
        $rettext = "";
        foreach (\common\models\Item::find()->where('item_category_id=' . $id)->all() as $menuitem) {
            $rettext .= $menuitem->name . "\n" . $retimg . "\n";
        }


        $ret = array('text' => $rettext);





        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function actionBranchList() {
        $branch = array();
        foreach (\common\models\Branch::find()->all() as $branches) {
            $branch[$branches->id] = $branches->name;
        }

        $ret = array();
        $ret = $branch;



        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    
    
    
     public function actionLogin() {

        
        if ($_GET['CRT'] == 1 and !Yii::$app->user->isGuest ) {

                    return $this->redirect(['/site/cart']);
        }

        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->login()) {



                ProductOrder::guest_order();


                //return $this->redirect(['site/index']);
                if ($_POST['back'] == 1) {
                    return $this->render('submit_order');
                }
                if ($_GET['back_to_cart'] == 1) {

                    return $this->render('cart');
                }
                if ($_GET['CRT'] == 1) {

                    return $this->redirect(['/site/address']);
                }
                //echo "X";

                return $this->render('site/cart');
            } else {
                return $this->render('login', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }
    
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {


                    ProductOrder::guest_order();

                    return $this->redirect(['site/index']);
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

   

    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionAdd_to_card_ajax($product_id, $qty) {
        return ProductOrder::add_to_card($product_id, $qty);
    }

    public function actionCart() {

        $_order_items = ProductOrder::get_cart_items();
        return $this->render('cart', [
                    'order_items' => $_order_items
        ]);
    }

    public function actionAddress() {



        $order = ProductOrder::check_order(0, TRUE);
        $address_object = new ProductAddress();;

        $order->scenario = 'check_address';


        if ($order->load(Yii::$app->request->post()) && $address_object->load(Yii::$app->request->post()) and $order->address_id) {
            $log = new \common\models\ProductTrackingLog();
            $log->order_id = $order->id;
            $log->status = 0;
            $log->time = date("Y-m-d h:i:sa");
            $log->save();
            $order->date = date("Y-m-d h:i:sa");


            if ($order->address_id > 0) {
                if ($order->save()) {
                    return $this->redirect(['site/send',
                                'order_id' => $order->id,
                    ]);
                }
            } else {

                $address_object->user_id = Yii::$app->user->identity->id;

                if ($address_object->save() and $address_object->address) {
                    $order->address_id = $address_object->id;

                    $order->save();
                    return $this->redirect(['site/send',
                                'order_id' => $order->id,
                                    ]
                    );
                } else {
                    if (!$address_object->address) {

                        $address_object->addError('address', 'آدرس نمی تواند خالی باشد');
                    }
                    return $this->render('address', [
                                'address_object' => $address_object,
                                'order' => $order,
                                'open_address' => TRUE
                    ]);
                }
            }
        } else {

            return $this->render('address', [
                        'address_object' => $address_object,
                        'order' => $order,
            ]);
        }
    }

    public function actionErsal($shipmethod) {


        echo \common\models\Order::get_Shipping_method_price($shipmethod);
    }

    public function actionSend() {


        ProductOrder::cal_order_sum();
        $order = ProductOrder::find()->innerJoinWith('address')->where(['product_order.id' => ProductOrder::check_order(0)])->one();


        $location_id = ProductAddress::find()->where(['id' => $order->address->id])->one()->city_id;


        $ship_m = \common\models\ProductShippingHasLocation::find()
                ->innerjoinWith('shippingMethod')
                ->where(['location_id' => $location_id])
                ->all();


        return $this->render('send', [
                    'ship_m' => $ship_m,
        ]);
    }

    public function actionPayment() {
       
        if ($_POST['shipping_radio']) {

            \common\models\Order::get_Shipping_method_price($_POST['shipping_radio'], 1);
        }

        $order = ProductOrder::check_order(0, TRUE);
        //echo $order->id;
        $is_credit = $_GET['is_credit'];
        if ($is_credit == 1) {
            
            $credit = \common\models\User::findone(Yii::$app->user->identity->id)->credit;

            $order->price_final = $order->price_final - $credit;

            $order->save();

            $credit_log = new CreditTransition();
            $credit_log->user_id = Yii::$app->user->identity->id;
            $credit_log->order_id = $order->id;
            $credit_log->date = date("Y-m-d h:i:sa");
            $credit_log->amount = $order->price_final; //enqad kam shode azash
            $credit_log->description = 1;

            if ($credit_log->save()) {
                
            }

            $user_credit = \common\models\User::findone(yii::$app->user->identity->id);
            $user_credit->credit = $user_credit->credit - $credit_log->amount;
            if ($user_credit->credit < 0) {
                $user_credit->credit = 0;
            }
            $user_credit->save();
        }
        return $this->render('payment', [
                    'order' => Post::arabic_w2e(number_format($order->price)),
        ]);
    }

    public function actionTracking() {


        if ($_POST['payment']) {

            $_order = ProductOrder::check_order(0, TRUE);
            if ($_order) {
                $_order->payment_id = $_POST['payment'];
                $_order->status = 2;
                $_order->payment_method_id = $_POST['payment'];
                if($_order->price_final == 0){
                    $_order->price_final = $_order->price;
                }
                $_order->save();
                $log = new \common\models\ProductTrackingLog();
                $log->order_id = $_order->id;
                $log->status = 2;
                $log->time = date("Y-m-d h:i:sa");

                $log->save();


                
                if($_order->payment_method_id == 1){
                    $this->redirect(['payment_req','id'=>$_order->id]);
                }


                /*
                 * To change this license header, choose License Headers in Project Properties.
                 * To change this template file, choose Tools | Templates
                 * and open the template in the editor.
                 */




                return $this->render('tracking', [
                            'order' => $_order->id,
                            'msg' => $msg,
                ]);
            } else {
                $this->redirect('index');
            }
        } else {
            return $this->redirect(['site/payment']);
        }
    }

    public function actionState($id = 0) {
        $loc1 = \common\models\location::find()
                ->where('state_id=' . $id)
                ->all();

        $arr = array();
        foreach ($loc1 as $city) {
            $arr[$city->id] = $city->name;
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionRemove($item) {
        //echo $item_id;
        $order_id = \common\models\ProductItem::findOne($item);
        if ($order_id->id) {
            $order_id->delete();
            $count = \common\models\Order::get_order_count();
            $arr['count'] = $count;
            // $arr['carthtml'] = \common\models\Order::get_cart_items_html();
            return json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionOrder() {
        $searchModel = new \common\models\Orders();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams, Yii::$app->user->identity->id);

        $query = ProductOrder::find()
                ->where('user_id=' . Yii::$app->user->identity->id)
                ->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);


        $ord = $query->offset($pages->offset)
                ->limit(10)
                ->all();



        return $this->render('order', [
                    'ord' => $ord,
                    'pages' => $pages,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id) {

        $order_d = \common\models\ProductItem::find()
                ->where('order_id=' . $id)
                ->all()
        ;
        return $this->render('details', [
                    'order_d' => $order_d,
        ]);
    }

    public function actionAccount() {

        return $this->render('account');
    }

    public function actionAddinfo($id) {

        $model = \common\models\User::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $msg = 'اطلاعات شما با موفقیت ثبت شد';
            }


            return $this->render('addinfo', [
                        'model' => $model,
                        'msg' => $msg,
            ]);
        } else {
            return $this->render('addinfo', [
                        'model' => $model,
            ]);
        }
    }

    public function actionGsearch($s) { // g algoritm avis
        $query_post = \common\models\Post::find()
                        ->orWhere(['like', 'title', $s])
                        ->orWhere(['like', 'body', $s])->all();

        $query_product = \common\models\Product::find()
                        ->orWhere(['like', 'name', $s])
                        ->orWhere(['like', 'summery', $s])
                        ->orWhere(['like', 'english_name', $s])
                        ->orWhere(['like', 'code', $s])
                        ->orWhere(['like', 'body', $s])->all();






        //->limit(3)
//        $countQuery = clone $query;
//        
//        echo $countQuery->count();
//
//        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 8]);
//
//        $catss = $query->offset($pages->offset)
//                ->orderBy(['id' => SORT_DESC])
//                ->limit(8)
//                ->all();
        return $this->render('search', [
                    'postS' => $query_post,
                    'productS' => $query_product,
                    'query' => $s,
        ]);
    }

    public function actionTrack_order() {
        $model = new \common\models\OrderCheck();
        if ($model->load(Yii::$app->request->post())) {
            $user_id = \common\models\User::find()->where(['email' => $model->order_email])->one()->id;

            $check_order = ProductOrder::find()->where('id=' . $model->order_id)->andwhere('user_id=' . $user_id)->one();
            if (!$check_order) {
                $model->order_id = null;
            }

            return $this->render('tracking_process', [
                        'order_id' => $model->order_id,
            ]);
        } else {


            return $this->render('track_order', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUser_order_history() {
        $id = Yii::$app->user->identity->id;
        $searchModel = new \common\models\Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('user_order_history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTracking_process($order_id) {
        return $this->render('tracking_process', [
                    'order_id' => $order_id,
        ]);
    }
     public function actionPayment_verify() {
         if ($_POST['ResCode'] == '0') {
	//--پرداخت در بانک باموفقیت بوده
	include_once('lib/nusoap.php');
	$client = new \nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
 
	$terminalId		= "3633310";					// Terminal ID
$userName		= "mkjnh2136";					// Username
$userPassword           = "36999615";					// Password
	$orderId 				= $_POST['SaleOrderId'];		// Order ID
	
	$verifySaleOrderId 		= $_POST['SaleOrderId'];
	$verifySaleReferenceId 	= $_POST['SaleReferenceId'];
			
	$parameters = array(
		'terminalId' => $terminalId,
		'userName' => $userName,
		'userPassword' => $userPassword,
		'orderId' => $orderId,
		'saleOrderId' => $verifySaleOrderId,
		'saleReferenceId' => $verifySaleReferenceId);
	// Call the SOAP method
	$result = $client->call('bpVerifyRequest', $parameters, $namespace);
	if($result == '0') {
		//-- وریفای به درستی انجام شد٬ درخواست واریز وجه
		// Call the SOAP method
		$result = $client->call('bpSettleRequest', $parameters, $namespace);
		if($result == '0') {
			//-- تمام مراحل پرداخت به درستی انجام شد.
			//-- آماده کردن خروجی
			echo 'The transaction was successful';
		} else {
			//-- در درخواست واریز وجه مشکل به وجود آمد. درخواست بازگشت وجه داده شود.
			$client->call('bpReversalRequest', $parameters, $namespace);			
			echo 'Error3 : '. $result;
		}
	} else {
		//-- وریفای به مشکل خورد٬ نمایش پیغام خطا و بازگشت زدن مبلغ
		$client->call('bpReversalRequest', $parameters, $namespace);
		echo 'Error2 : '. $result;
	}
} else {
	//-- پرداخت با خطا همراه بوده
	echo 'Error1 : '. $_POST['ResCode'];
         echo $orderId;
} 
         
     }
     
    
     
     
     public function actionCheck_order($id) {
         
        $o_obj =  ProductOrder::findOne($id);
      //  echo $o_obj->status."****";
         return $this->render('check_order', [
             'order_obj' => $o_obj
     ]);
         
     }
     
     
    
    public function actionPayment_req($id) {
        
        $terminalId		= "3633310";					// Terminal ID
$userName		= "mkjnh2136";					// Username
$userPassword           = "36999615";					// Password
$orderId		= $id;						// Order ID

$order = ProductOrder::findOne($id);



$amount 		= $order->price_final;						// Price / Rial
$localDate		= date('Ymd');					// Date
$localTime		= date('Gis');					// Time
$additionalData	= '';
$callBackUrl	= "http://size.ir/site/payment_verify";	// Callback URL
$payerId		= '0';

//-- تبدیل اطلاعات به آرایه برای ارسال به بانک
$parameters = array(
	'terminalId' 		=> $terminalId,
	'userName' 			=> $userName,
	'userPassword' 		=> $userPassword,
	'orderId' 			=> $orderId,
	'amount' 			=> $amount,
	'localDate' 		=> $localDate,
	'localTime' 		=> $localTime,
	'additionalData' 	=> $additionalData,
	'callBackUrl' 		=> $callBackUrl,
	'payerId' 			=> $payerId);

$client = new \nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
$namespace='http://interfaces.core.sw.bps.com/';
$result 	= $client->call('bpPayRequest', $parameters, $namespace);
//-- بررسی وجود خطا
if ($client->fault)
{
	//-- نمایش خطا
	echo "There was a problem connecting to Bank";
	exit;
} 
else
{
	$err = $client->getError();
	if ($err)
	{
		//-- نمایش خطا
		echo "Error : ". $err;
		exit;
	} 
	else
	{
		$res 		= explode (',',$result);
		$ResCode 	= $res[0];
		if ($ResCode == "0")
		{
			//-- انتقال به درگاه پرداخت
			echo '<form name="myform" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
					<input type="hidden" id="RefId" name="RefId" value="'. $res[1] .'">
				</form>
				<script type="text/javascript">window.onload = formSubmit; function formSubmit() { document.forms[0].submit(); }</script>';
			exit;
		}
		else
		{
			//-- نمایش خطا
			echo "Error : ". $result;
			exit;
		}
	}
}
        
    }

}
