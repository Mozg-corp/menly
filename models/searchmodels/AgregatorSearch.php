<?php

namespace app\models\searchmodels;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AgregatorBase;

/**
 * AgregatorSearch represents the model behind the search form of `app\models\AgregatorBase`.
 */
class AgregatorSearch extends AgregatorBase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'expire'], 'integer'],
            [['name', 'apiv1', 'apiv2', 'token', 'refresh_token', 'logo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = AgregatorBase::find();

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
            'id' => $this->id,
            'expire' => $this->expire,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'apiv1', $this->apiv1])
            ->andFilterWhere(['like', 'apiv2', $this->apiv2])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'refresh_token', $this->refresh_token])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
