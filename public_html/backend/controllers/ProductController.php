<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ProductHasAttGroup;
use common\models\AttGroup;
use common\models\ProductHasCategory;
use common\models\Category;
use common\models\ProductCategory;
use yii\web\UploadedFile;
use app\web\Uploads;
use yii\base\Model;
use common\models\AttValue;
use common\models\Price;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use common\models\ProductHasAttSet;
use common\models\Variant;
use yii\db\Query;

class ProductController extends Controller {

    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['compeletegallery', 'calc', 'unlock', 'index', 'create', 'delete', 'view', 'lvl', 'update', 'index2', 'index3', 'f1', 'bulk', 'bulk2', 'save', 'drafts', 'urldl', 'slug', 'logout', 'upload', 'setatt', 'getoptionvalue', 'saveoptionvalue', 'savevariant', 'userlist', 'productlist', 'productvariant'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                    return (\Yii::$app->user->identity->level_id == 10 );
                }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2($id) {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search2($id);

        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex3() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, -1);

        return $this->render('index2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload() {

$sitebase=dirname(dirname(dirname(dirname(__FILE__))));


        //echo json_encode(['last_id'=>'no file found for upload.']);
        //    return; 
        if (empty($_FILES['file'])) {
            echo json_encode(['eror' => 'no file found for upload.']);
            return;
        }
        $files = $_FILES['file'];
        $success = null;
        $paths = [];
        $list = "";
        $filenames = $files['name'];
        //$folder = md5(uniqid());
        //if (!file_exists('/home/naptad/public_html/ppp'.DIRECTORY_SEPARATOR. $folder)) {
        //    mkdir('/home/naptad/public_html/ppp'.DIRECTORY_SEPARATOR. $folder, 0777,true);
        //}
        for ($i = 0; $i < count($filenames); $i++) {

            $ext = explode('.', basename($filenames[$i]));
            $target = $sitebase."/public_html/backend/web/uploads" . DIRECTORY_SEPARATOR . $filenames[$i];
            if (move_uploaded_file($files['tmp_name'][$i], $target)) {



                //$list.="|".$target;
                $success = true;
                $paths[] = $target;
            } else {
                $success = false;

                break;
            }
        }


        if ($succes == true) {

            $output = ['eror' => 'File Uploaded'];
        } elseif ($success === false) {

            $output = ['eror' => 'eror while Uploading Images'];
            foreach ($paths as $file) {
                unlink($file);
            }
        } else {
            $output = ['eror' => 'No File Were Processed'];
        }

        echo json_encode($output);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        Yii::$app->cacheFrontend->flush();
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function actionCreate() {

        $model = new Product();
        $price = new \common\models\ProductPrice();
        
        if ($model->load(Yii::$app->request->post())) {
             $model->date = date('Y-m-d H:i:s');

            //$model->date = $_POST['Product']['date'];

            
            $model->img1 = UploadedFile::getInstance($model, 'img1');
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->link = UploadedFile::getInstance($model, 'link');


            if ($_POST['clearimg'] == "on") {

                $model->image = " ";
            } else {
                if ($model->img1->basename) {

                    $basfname = "uploads/" . $this->generateRandomString(15);
                    $model->img1->saveAs($basfname . '.' . $model->img1->extension);
                    $model->image = $basfname . '.' . $model->img1->extension;
                }
            }
            if ($_POST['clearimg2'] == "on") {
                $model->image_2 = " ";
            } else {
                if ($model->file->basename) {

                    $basfname = "uploads/" . $this->generateRandomString(15);
                    $model->file->saveAs($basfname . '.' . $model->file->extension);
                    $model->image_2 = $basfname . '.' . $model->file->extension;
                }
            }


            if ($model->link->basename) {

                $basfname = "uploads/" . $this->generateRandomString(15);

                $model->link->saveAs($basfname . '.' . $model->link->extension);
                $model->link = $basfname . '.' . $model->link->extension;
            }

            $model->slug = Product::getSlug($model->name . '-' . $model->id);
            if ($model->save()) {
                //Yii::$app->cacheFrontend->flush();
            } else {
                print_r($model->getErrors());
                exit();
            }
            



            if (( $_POST['Product']['attrc'])) {

                $len = count($_POST['Product']['attrc']);
                for ($i = 0; $i < $len; $i++) {
                    $p2 = new ProductHasCategory();


                    $p2->product_category = ( $_POST['Product']['attrc'][$i]);
                    $p2->product_id = $model->id;
                    $p2->save();
                }
            }
            
                if ($price->load(Yii::$app->request->post())) {

 $price->product_id = $model->id;
                   
$price->save();
    }

if(!$model->save()){
    print_r($model->getErrors());
    exit();
}
 $price->product_id = $model->id;
  $price->selling_rate = $model->pricef->selling_rate;
        $price->buying_rate = $model->pricef->buying_rate;
        $price->save();


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('_form', [
                        'model' => $model,
                        'price' => $price,
                        
            ]);
        }
    }

    public function actionUpdate($id) {
        


        $model = $this->findModel($id);
        $price = new \common\models\ProductPrice();

        $price->selling_rate = $model->pricef->selling_rate;
        $price->buying_rate = $model->pricef->buying_rate;
        
      
        if ($model->load(Yii::$app->request->post())) {
             $model->date = date('Y-m-d H:i:s');
            if ($_POST['custom_var']) {
                $model->default_variant = $_POST['custom_var'];
            }
           
            

           
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->link = UploadedFile::getInstance($model, 'link');
            $model->img1 = UploadedFile::getInstance($model, 'img1');

            
            if ($_POST['clearimg'] == "on") {

                $model->image = " ";
            } else {
                if ($model->img1->basename) {

                    $basfname = "uploads/" . $this->generateRandomString(15);
                    $model->img1->saveAs($basfname . '.' . $model->img1->extension);
                    $model->image = $basfname . '.' . $model->img1->extension;
                }
            }
            if ($_POST['clearimg2'] == "on") {
                $model->image_2 = " ";
            } else {
                if ($model->file->basename) {

                    $basfname = "uploads/" . $this->generateRandomString(15);
                    $model->file->saveAs($basfname . '.' . $model->file->extension);
                    $model->image_2 = $basfname . '.' . $model->file->extension;
                }
            }

            if ($model->link->basename) {

                $basfname = "uploads/" . $this->generateRandomString(15);

                $model->link->saveAs($basfname . '.' . $model->link->extension);
                $model->link = $basfname . '.' . $model->link->extension;
            }
            
            $model->slug = Product::getSlug($model->name . '-' . $model->id);
              

            if ($price->load(Yii::$app->request->post())) {
                if( ($price->selling_rate or $price->buying_rate ) and( $price->selling_rate != $model->pricef->selling_rate or $price->buying_rate != $model->pricef->buying_rate ) ){
                    $price->product_id = $model->id;
                    $price->save();
                }
            }

                $m = ProductHasCategory::deleteAll('product_id=' . $model->id);
                

                $model->attrc = ( $_POST['Product']['attrc'] );
                if ($model->attrc) {
                    $len = count($model->attrc);
                    for ($i = 0; $i < $len; $i++) {
                        $p2 = new ProductHasCategory();
                        $p2->product_category = $model->attrc[$i];
                        $p2->product_id = $model->id;
                        $p2->save();
                    }
                }
                if ($model->attrme) {


                    $len = count($model->attrme);


                    for ($i = 0; $i < $len; $i++) {
                        $p2 = new ProductHasAttGroup();
                        $p2->att_group_id = $model->attrme[$i];
                        $p2->product_id = $model->id;
                        $p2->save();
                    }
                }
         
            if ($_POST['Product']['att_set_id']) {


                $len = count($_POST['Product']['att_set_id']);

                for ($i = 0; $i < $len; $i++) {
                    $p2 = new ProductHasAttSet();
                    $p2->att_set_id = $_POST['Product']['att_set_id'][$i];
                    $p2->product_id = $model->id;
                    $p2->save();
                }
            }
            
              if ($model->save()) {
                    Yii::$app->cacheFrontend->flush();
                }




            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('_form', [
                        'model' => $model,
                        'price' => $price,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
   

    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetatt($id) {

        

        $list = (Product::getProductCats($id));



        $list_att_gr = \common\models\ProductCategoryHasAttGroup::find()
                ->innerJoinWith('attGroup')
                ->where(['category_id' => $list])
                ->all();


       

        //echo count($list_att_gr);
        //exit();
        //echo "1<br>";


        $string = Yii::$app->request->post('att_value');

        //$stringHash = $string;

        $att_id = Yii::$app->request->post('att_id');
        $att_price = Yii::$app->request->post('att_val_price');
        $value_id = Yii::$app->request->post('value_id');

        //$stringHash = "4*".$string;


        if ($string != "") {


            //echo "2<br>";



            /*
              $pm = common\models\AttValue::find()
              ->where('product_id='.$id." AND att_id=".$attbiute->id)
              ->one();

              if($pm->id){




              $pm->value = $string;
              if($pm->save()){
              $stringHash = "به روزسانی شد" ;
              }else{
              $stringHash = "بروز خطا" ;
              } */


            if ($value_id) {

                $m = \common\models\ProductAttValue::deleteAll('id=' . $value_id);
            }



            $p = new \common\models\ProductAttValue();
            $p->value = $string;
            $p->att_id = $att_id;
            $p->product_id = $id;
            $p->price = $att_price;




            if ($p->save(false)) {



                $stringHash = " &#9989;";
            } else {
                $stringHash = "بروز خطا  GL";
            }
        } else {
            if ($value_id) {
                $m = \common\models\ProductAttValue::deleteAll('id=' . $value_id);
                $stringHash = "اطلاعات حذف شد صفحه را رفرش کنید";
            }
        }



        return $this->render('setatt', [
                    'attlist' => $list_att_gr,
            'stringHash' => $stringHash, 'id' => $id
        ]);
    }

    public function actionSetatt2() {  


        $string = Yii::$app->request->post('string'); 
        $stringHash = '';
        if (!is_null($string)) {
            $stringHash = ($string);
        }
        return $this->render('form-submission', [
                    'stringHash' => $stringHash,
        ]);
        return $this->render('xpajax', ['time' => date('H:i:s')]);
    }

    public function actionGetoptionvalue($optionnameid) {
        //  با آیدی نام آپشن انتخاب شده آپشن ولیو ها رو انتخاب کردیم
        $option_value = \common\models\AttOption::find()
                ->where('att_id=' . $optionnameid)
                ->all();
        //تعداد آپشن ولیو های پیدا شده
        $counter = count($option_value);
        //آیدی اون آپشن رو هم فرستادیم

        $arr['option_name'] = $optionnameid;
        if (($counter) > 0) {


            foreach ($option_value as $option_values) {

                $arr['optionv_name'][] = $option_values->name;
                $arr['optionv_id'][] = $option_values->id;
            }

            $arr['flag'] = 1;
        } else {
            $arr['flag'] = 0;
        }
        $arr['counter'] = $counter;
        $arr['option_name_label'] = \common\models\Att::findOne($optionnameid)->name;
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionSaveoptionvalue() {

//          print_r($_POST);
//          exit();
//            
        $array_option_value_name = array();
        $i = 0;

        foreach ($_POST as $key => $value) {

            if (substr($key, 0, 12) == 'option_value') {


                foreach ($_POST[$key] as $option) {
                    $i++;

                    $zero = substr($option, 0, 1);


                    // جدید نبود
                    // از آپشن ولیو ها پیدا کن 
                    if (!($zero == "#")) {
                        $op = \common\models\AttOption::findOne($option);
                        $array_option_value_name[(substr($key, 13))][$i] = $op->name;
                    } else {


                        $opt_name = new \common\models\OptionValue();
                        $opt_name->name = substr($option, 1);
                        $opt_name->option_name_id = (substr($key, 13));
                        if ($opt_name->save()) {
                            //echo 'ذخیره شد' . ' '. $option;
                            $array_option_value_name[$opt_name->option_name_id][$i] = $option;
                        } else {
                            //echo 'ذخیره نشد';
                            print_r($opt_name->getErrors());
                        }
                    }
                }
            }// end if
        }//end foreach
        return $this->render('step2', [
                    'array_option_value_name' => $array_option_value_name
        ]);
    }

    public function actionSavevariant($option_v_name, $variant_data, $v_productid) {

        //echo $variant_data;
        $ex2 = explode(',', $variant_data);
        $optionValue_name = (rtrim($option_v_name, ','));
        $ex = explode(',', $optionValue_name);
        
        

        if ($variant_data) {

            if (!(($ex2[2] == "") or  ($ex2[0] == ""))) {

                $variant = new Variant();
                $variant->product_id = $v_productid;
                $variant->qty = $ex2[0];
              
                $variant->barcode = ($ex2[3]);
                $variant->barcode_text = ($ex2[4]);
                $variant->order = ($ex2[5]);
                if ($variant->save()) {
                    // echo 'ذخیره شد';

                    $_price = new \common\models\ProductPrice();
                    $_price->variant_id = $variant->id;
                    $_price->buying_rate = (int) ($ex2[1]);
                    $_price->selling_rate = (int) ($ex2[2]);
                    $_price->save();
                    
                   // print_r($_price->getErrors());



                    foreach ($ex as $ex3) {
                        
                        $option = \common\models\AttOption::find()
                                ->where(['name' => $ex3])
                                ->one();
                        //echo $ex3;
                        

                        $option_has_variant = new \common\models\OptionHasVariant();
                        $option_has_variant->option_id = $option->id;
                        $option_has_variant->variant_id = $variant->id;

                        if ($option_has_variant->save()) {

                            $arr['flag'] = 1;
                            $arr['variant_id'] = $variant->id;
                        } else {
                            
                          

                            $arr['flag'] = 0;
                            

//                        $arr['err_full']=$err;
                            //print_r($option_has_variant->getErrors());
                            // echo '<br>option has variant error';
                        }
                    }
                } else {
                    $arr['flag'] = 8;
                    $arr['variant_id'] = 0;
                    $err = array();
                    //print_r($variant->getErrors());
                    //print_r($variant->getErrors());
                }
            } else {

                $arr['flag'] = 0;
                $arr['err'] = 'لطفا فیلد ها را پر کنید';
            }
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionUserlist($q = null, $id = null) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name_and_fam AS text')
                    ->from('user')
                    ->orwhere(['like', 'name_and_fam', $q])
                    ->orWhere(['like', 'phone_number', $q])
                    // ->orWhere(['like', 'cell_number', $q])
                    ->orWhere(['like', 'cell_number', "%" . $q . "%", false])
                    ->orWhere(['like', 'username', $q])
                    ->orWhere(['like', 'address', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $ur = \common\models\User::find($id);
            $out['results'] = ['id' => $id, 'text' => $ur->name_and_fam];
        }

        return $out;
    }

    public function actionProductlist($q = null, $id = null) {


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                    ->from('product')
                    ->where(['like', 'name', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Product::find($id)->name];
        }

        return $out;
    }

    public function actionProductvariant($p_id) {

        $array = array();
        $v = Variant::find()
                ->where('product_id=' . $p_id)
                ->all();




        foreach ($v as $variant) {


            $m = \common\models\OptionHasVariant::find()->where('variant_id=' . $variant->id)->all();
            $ret = "";
            $m_id = $variant->id;

            foreach ($m as $var) {



                $m = \common\models\OptionValue::findOne($var->option_id);
                $ret.= $m->name . ' ';
            }


            $arr[$m_id] = $ret;
        }



        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public function actionCalc($id) {
        $min = 0;
        $max = 0;
        $array_price = array();

        $v = \common\models\Variant::find()
                ->where('product_id=' . $id)
                ->all();

        if (count($v) > 0) {
            foreach ($v as $variant) {
                array_push($array_price, $variant->price);
            }

            $min = min($array_price);
            $max = max($array_price);

            $product = Product::findOne($id);
            $product->price_range = $min . '-' . $max;
            $product->save();
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCompeletegallery($id) {
        $min = 0;
        $max = 0;
        $array_price = array();

        $v = \common\models\Variant::find()
                ->where('product_id=' . $id)
                ->all();
        $p = Product::findOne($id);

        if (count($v) > 0 and $p->id) {

            foreach ($v as $variant) {
                $p->gallery.= "http://" . $_SERVER['SERVER_NAME'] . "/backend/web/" . $variant->img . "\n";
            }


            $p->save();
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSlug() {
        $p = Product::find()->all();
        foreach ($p as $post) {

            $post->slug = Product::getSlug('پت شاپ' . ' ' . $post->name . '-' . $post->id);
            $post->save();
            echo $post->slug . '<br>';
        }
    }

}
