<?php

namespace app\models\searchmodels;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\UserBase`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'status'], 'safe'],
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
        $query = \app\models\User::find();
		$query->joinWith(['profile', 'car']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'sort' => [
				'attributes' => [
					'lastname',
					'firstname',
					'secondname',
					'status',
					'create_at'
				],
				'defaultOrder' => [
					'status' => SORT_ASC,
					'lastname' => SORT_ASC,
					'firstname' => SORT_ASC,
					'secondname' => SORT_ASC,
				]
			]
			// 'sort' => [
				// 'defaultOrder' => $sort
			// ]
        ]);
// return $query->one()->profile;
        $this->load($params, '');

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // return $dataProvider;
        //}
		// print_r($this->rules());
        // grid filtering conditions
		//$lastname = $params['lastname']??'';
// print_r($this->status);die;
		$query->andFilterWhere([
			'status' => $this->status
		]);
        $query->andFilterWhere(['like', 'users.phone', $this->phone]);
        $query->andFilterWhere(['like', 'lastname', $params['lastname']??'']);
		// $query->orderBy($sort->orders);
        // $query->andFilterWhere(['like', 'lastname', 'Бараниченко']);
		// print_r($query->all());
        // return $query->all();
        return $dataProvider;
    }
}
