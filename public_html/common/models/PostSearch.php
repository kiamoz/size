<?php

namespace common\models;

use Yii;
use yii\base\Model; 
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\PostSearch;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public  $category_id;
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'body', 'date', 'file_path', 'thumb_nail', 'summery','category_id'], 'safe'],
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

    
    public function search($params)
    {
        $query = Post::find()->orderBy(['update_date'=> SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
           
        ]);
        
        if($this->category_id){
             $query->innerJoinWith('posthasCategory');
             $query->andFilterWhere(['post_has_category.category_id'=>$this->category_id]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 'thumb_nail', $this->thumb_nail])
            ->andFilterWhere(['like', 'summery', $this->summery]);

        return $dataProvider;
    }
    
    
}
