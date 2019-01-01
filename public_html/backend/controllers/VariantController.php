<?php

namespace backend\controllers;

use Yii;
use common\models\Variant;
use common\models\VariantS; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\VariantPrice;

/**
 * VariantController implements the CRUD actions for Variant model.
 */
class VariantController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                 //   'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Variant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VariantS();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Variant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Variant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  
    /**
     * Updates an existing Variant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);
       $price = new \common\models\ProductPrice();
        if ($model->load(Yii::$app->request->post())) {
            
            if ($price->load(Yii::$app->request->post())) {
                $price->variant_id = $model->id;
                $price->save();
            }
            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file->basename){
            
            $basfname = "uploads/".$this->generateRandomString(15);
	    $model->file->saveAs($basfname. '.'.$model->file->extension);
	    $model->img = $basfname. '.'.$model->file->extension;
            }
            $model->price =  $price->sales_price;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'price' => $price,
            ]);
        }
    }

    /**
     * Deletes an existing Variant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['product/index2','id'=>$_GET['pid']]);
    }

    /**
     * Finds the Variant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Variant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Variant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
}
    