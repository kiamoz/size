<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ProductHasCategory;
use common\models\ProductOrder;
use common\models\ProductOrder_serach;
use common\models\Item;
use common\models\ItemHasOrder;
use common\models\Comment;
use yii\data\Pagination; 

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    public function behaviors() { 
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'actions' => ['view', 'category', 'tag', 'collection', 'all-cats', 'result', 'variantshow'],
                        'allow' => true,
                    //  'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionOrderHistory() {
        $searchModel = new ProductOrder_serach();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        
        
        
        $product= Product::findone($id);
        
        return $this->render('view', [
          'product'=>$product,  
        ]) ;
    }


 
    public function actionResult() {
        //print_r($_POST);
        //exit();
        // $_POST['option']=564;

        $a = \common\models\AttValue::find();

        if ($_POST['option']) {

            $a->andWhere(['value' => $_POST['option']]);
        }
        if ($_POST['yes']) {
            foreach ($_POST['yes'] as $yes) {

                //echo $yes."<br>";
                $a->andWhere('value=1 and att_id=' . $yes);
            }
        }
        if ($_POST['no']) {
            foreach ($_POST['no'] as $no) {
                $a->andWhere('value=0 and att_id=' . $no);
            }
        }

        $b = $a->all();

        //  exit();

        $arr = array();
        foreach ($b as $result) {
            array_push($arr, $result->product_id);
        }


        $searchname = $_POST['search'];
        $searchname = str_replace(" ", "%", $searchname);
        $queryyy = \common\models\ProductHasCategory::find();
        $queryyy->innerJoinWith('product', 'a');


        //if($categoryid != "all"){
        // $queryyy->andWhere(['product_category'=>$categoryid]);
        //}
        //if($searchname){
        $queryyy->andWhere(['like', 'name', "%" . $searchname . "%", false]);
        // }
        //->orderBy(['date' => SORT_DESC,])

        $queryyy->andWhere('product_category=' . $_POST['cat_id']);


        // $queryyy->orderBy(['id' => SORT_DESC]);
        $queryyy->groupBy('product_id');

        $m = $queryyy->all();




        $p = \common\models\ProductHasCategory::find()
                        ->innerJoinWith('product', 'a')
                        ->andWhere(['product_id' => $arr])
                        ->andWhere('product_category=' . $_POST['cat_id'])->all();


        $list_att_gr = \common\models\ProductCatHasAttSet::find()
                ->innerJoinWith('productCat', 'sss')
                ->where(['product_cat_id' => $_POST['cat_id']])
                ->all();



        return $this->render('result', [
                    'cate' => $m,
                    'cat_id' => $_POST['cat_id'],
                    'p' => $p,
                    'list_att_gr' => $list_att_gr,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//        public function actionCategory($id)
//    { 
//            
//            
//            if(!is_numeric($id)){
//
//            $id = Product::getProductCatId($id);
//            if(!$id){
//                return $this->redirect(['site/index']);
//            }
//        }
//            
//            
//            $query = ProductHasCategory::find()
//            ->innerJoinWith('product')
//            ->orderBy(['date' => SORT_DESC,])
//
//            ->where('product_category='.$id);
//    
//    
//    $countQuery = clone $query;
//    $pages = new Pagination(['totalCount' => $countQuery->count()]);
//    $cats  = $query->offset($pages->offset)
//        ->limit(20)
//        ->all();
//            
//            
//            
//	  
//  
//        return $this->render('category', [
//	       'cate' => $cats, 
//               'pages' => $pages,
// 
//        ]);
//	  
//    }

    public function actionCategory($id) {


        $cats = ProductHasCategory::find()->with('product')->where('product_category=' . $id);

        $countQuery = clone $cats;
        $page_limit = \common\models\Sitesetting::findone(1)->pagination;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $page_limit]);

        $post_to_show = $cats->offset($pages->offset)
                ->orderBy(['product_id' => SORT_DESC])
                ->limit($page_limit)
                ->all();



        return $this->render('category', [
                    'id' => $id,
                    'post_array' => $post_to_show,
                    'page_setup' => $pages,
        ]);
    }

    public function actionAllCats($id = 0) {

        if (!is_numeric($id)) {

            $id = \common\models\ProductCategory::getProductCategoryId($id);

            if (!$id) {
                return $this->redirect(['site/index']);
            }
        }

        if ($id == 0) {
            $query = \common\models\CategoryHasCategory::find()
                    ->innerJoinWith('productCategory')
                    ->where('parent_category=0')
                    ->orderBy(['order_show' => SORT_ASC]);
        } else {
            $query = \common\models\CategoryHasCategory::find()
                    ->innerJoinWith('productCategory')
                    ->where('parent_category=' . $id)
                    ->orderBy(['order_show' => SORT_ASC]);
        }


        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);


        $cats = $query->offset($pages->offset)
                ->limit(18)
                ->all();





        return $this->render('category', [
                    'cate' => $cats,
                    'pagess' => $pages,
        ]);
    }

    public function actionAddtocrad() {



        print_r($_POST);
    }

    public function actionGallery() {




        return $this->render('gallery', [
        ]);
    }

    public function actionTag($id) {
        $cats1 = \common\models\MoalefHasProduct::find()
                ->with('product')
                ->where('moalef_id=' . $id)
                ->all();

        return $this->render('tag', [
                    'cate' => $cats1,
        ]);
    }

    public function actionCollection($id) {
        if (!is_numeric($id)) {

            $id = \common\models\ProductCategory::getProductCategoryId($id);

            if (!$id) {
                return $this->redirect(['site/index']);
            }
        }
        $list_att_gr = \common\models\ProductCatHasAttSet::find()
                ->innerJoinWith('productCat', 'sss')
                ->where(['product_cat_id' => $id])
                ->all();

        $query = \common\models\ProductHasCategory::find()
                ->innerJoinWith('product', 'a')
                ->where('product_category=' . $id)
                ->andWhere('visible=0')
                ->orderBy(['order_show' => SORT_ASC])
                ->groupBy(['product.id']);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);


        $cats = $query->offset($pages->offset)
                ->limit(16)
                ->all();





        return $this->render('collection', [
                    'cate' => $cats,
                    'pagess' => $pages,
                    'list_att_gr' => $list_att_gr
        ]);
    }

    public function actionVariantshow($product_id, $arr) {
        //echo $product_id;
//        print_r($arr);
//        exit(); 
//        $all_v = \common\models\Variant::find()
//                ->where('product_id='.$product_id)
//                ->all();
//        $var_op_id = array();
//        foreach($all_v as $var){
//            array_push($var_op_id, $var->id);
//        }
//        
//        $var_selected_arr = explode(",", $arr);
//        //print_r($var_selected_arr);
//        
//        $all_v = \common\models\OptionHasVariant::find()
//                ->select(['variant_id,COUNT(*) AS cnt'])
//                ->where(['variant_id'=>$var_op_id])->andWhere(['option_id'=>$var_selected_arr])->groupBy('variant_id')->all();
//        
//        $arr_count = array();
//        
//        foreach($all_v as $var){
//            $arr_count[$var->variant_id] = $var->cnt;    
//        }
//        $keys = array_keys($arr_count, max($arr_count));
//        
//        //echo $keys[0].'key<br>';
//        $pr=  \common\models\Variant::findOne($keys[0]);
//        //echo $pr->price.'price';
//        
        $pr = \common\models\Variant::findOne($arr);

        $arr = array();
        $arr['id'] = $pr->id;
        if ($pr->qty) {
            $arr['avl'] = \common\models\Post::arabic_w2e($pr->qty);
            $arr['avl2'] = $pr->qty;
        } else {
            $arr['avl'] = 0;
        }
        if ($pr->price) {
            $arr['total'] = \common\models\Post::arabic_w2e(number_format($pr->price));
        } else {
            $arr['total'] = 0;
        }

        $arr['image'] = $pr->img;
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

}
