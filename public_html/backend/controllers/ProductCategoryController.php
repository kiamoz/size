<?php

namespace backend\controllers;

use Yii;
use common\models\ProductCategory;
use common\models\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\web\Uploads;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\ProductCategoryHasAttGroup;
use common\models\ProductCategoryHasCategory;

/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends Controller {

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
                        'actions' => ['unlock', 'index', 'create', 'delete', 'view', 'lvl', 'update', 'index2', 'index_2', 'f1', 'bulk', 'bulk2', 'save', 'drafts', 'urldl', 'slug', 'logout'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                    return (\Yii::$app->user->identity->level_id == 10);
                }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        Yii::$app->cacheFrontend->flush();
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

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
        Yii::$app->cacheFrontend->flush();
        $model = new ProductCategory();

        if ($model->load(Yii::$app->request->post())) {
            $model->date = $_POST['ProductCategory']['date'];


            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file->basename) {

                $basfname = "uploads/" . $this->generateRandomString(15);
                $model->file->saveAs($basfname . '.' . $model->file->extension);
                $model->img = $basfname . '.' . $model->file->extension;
            }
            $model->slug = ProductCategory::getSlug($model->name . '-' . $model->id);
            $model->save();

            if ($_POST['ProductCategory']['att_set_id']) {

                foreach ($_POST['ProductCategory']['att_set_id'] as $depe) {

                    $dep = new \common\models\ProductCatHasAttSet();
                    $dep->product_cat_id = $model->id;


                    $dep->att_set_id = ($depe);

                    if ($dep->save()) {
                        // echo "yes";
                    } else {
                        //print_r($dep->getErrors());
                    }
                }
            }
            //***** chc
            //print_r($_POST['ProductCategory']) ;
            // exit();
            if (( $_POST['ProductCategory']['attrchc'])) {
                //echo '**'; 
                $len = count($_POST['ProductCategory']['attrchc']);
                //echo $len;

                for ($i = 0; $i < $len; $i++) {
                    $p2 = new ProductCategoryHasCategory();


                    $p2->parent_category = ( $_POST['ProductCategory']['attrchc'][$i]);
                    $p2->category = $model->id;
                    $p2->save();
                }
            }


            ///******

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        Yii::$app->cacheFrontend->flush();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
        
            $model->update_date = date('Y-m-d H:i:s');


            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file->basename) {

                $basfname = "uploads/" . $this->generateRandomString(15);
                $model->file->saveAs($basfname . '.' . $model->file->extension);
                $model->img = $basfname . '.' . $model->file->extension;
            }
            $model->slug = ProductCategory::getSlug($model->name . '-' . $model->id);
            $model->save();


            \common\models\ProductCategoryHasCategory::deleteAll('category=' . $model->id);


            //***** chc


         
            

                


                 if($model->att_group_id){

                    foreach ($model->att_group_id as $id){
                        if(!ProductCategoryHasAttGroup::find()->where(['att_group_id'=>$id])->andwhere(['category_id'=>$model->id])->one()){
                            
                        
                           $dep = new ProductCategoryHasAttGroup();
                    $dep->category_id = $model->id;
                    
                    $dep->att_group_id = $id;

                    if ($dep->save()) {
                       //  echo "yes";
                     //    exit();
                    } else {
                     //  print_r($dep->getErrors());
                     //  exit();
                    }
                    }
                    }
                 }
                // exit();
            



            if (( $_POST['ProductCategory']['attrchc'])) {
                //echo '**'; 
                $len = count($_POST['ProductCategory']['attrchc']);
                //echo $len;

                for ($i = 0; $i < $len; $i++) {
                    $p2 = new ProductCategoryHasCategory();


                    $p2->parent_category = ( $_POST['ProductCategory']['attrchc'][$i]);
                    $p2->category = $model->id;
                    $p2->save();
//            if(){
//                echo 'save';
//                
//            }else{
//                print_r($p2->getErrors());
//                exit();
//            }
                }
            }


            ///******


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSlug() {
        $p = ProductCategory::find()->all();
        foreach ($p as $post) {

            $post->slug = ProductCategory::getSlug($post->name . '-' . $post->id);
            $post->save();
            echo $post->slug . '<br>';
        }
    }

}
