<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShippingHasLocation;

/**
 * ShippingHasLocationS represents the model behind the search form about `common\models\ShippingHasLocation`.
 */
class ShippingHasLocationS extends ShippingHasLocation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_id', 'location_id'], 'integer'],
            [['price'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShippingHasLocation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'shipping_id' => $this->shipping_id,
            'location_id' => $this->location_id,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
    
    
    public function search1($params,$loc)
    {
        $query = ShippingHasLocation::find()
                ->where('location_id='.$loc);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'shipping_id' => $this->shipping_id,
            'location_id' => $this->location_id,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
    
    
}
