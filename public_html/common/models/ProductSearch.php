<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product {

    /**
     * @inheritdoc
     */
    
    public $category_id;


    public function rules() {
        return [
            [['id'], 'integer'],
            [['name', 'barcode','code','category_id'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $is_not_avl) {
        $query = Product::find()
                ->orderBy(['order_show'=>SORT_DESC,'id' => SORT_DESC]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        
        if($this->category_id){
             $query->innerJoinWith('productHasCategory');
             $query->andFilterWhere(['product_has_category.product_category'=>$this->category_id]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'barcode', $this->barcode])
                 ->andFilterWhere(['like', 'code', $this->code]);
        return $dataProvider;
    }

  

}
