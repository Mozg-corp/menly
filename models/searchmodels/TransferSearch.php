<?php

namespace app\models\searchmodels;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransferSearch represents the model behind the search form of `app\models\UserBase`.
 */
class TransferSearch extends \app\models\Transfer
{
    public $lastname;
    public function rules()
    {
        return [
			[['lastname'], 'string', 'max' => 50],
            [['id_transfer_statuses', 'created_at', 'lastname'], 'safe']
        ];
    }
	public function fields(){
		return array_merge([
			'lastname'
		], parent::fields());
	}
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
        $query = TransferSearch::find();
		$query->joinWith(['profiles']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			 'sort' => [
				'attributes' => [
					'created_at',
					'id_transfer_statuses',
					'lastname',
				],
				'defaultOrder' => [
					'created_at' => SORT_DESC,
					'id_transfer_statuses' => SORT_ASC,
					'lastname' => SORT_ASC
				]
			]
        ]);
		
		// return $query->where(['lastname' => 'Арсений'])->all();
        $this->load($params, '');
		//return $params;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
		// print_r($this->rules());
        // grid filtering conditions
		//$lastname = $params['lastname']??'';
// print_r($this->status);die;
		$query->andFilterWhere([
			'id_transfer_statuses' => $this->id_transfer_statuses
		]);
		//return $query->one();
        //$query->andFilterWhere(['like', 'users.phone', $this->phone]);
        $query->andFilterWhere(['like', 'lastname', $this->lastname]);
		// $query->orderBy($sort->orders);
        // $query->andFilterWhere(['like', 'lastname', 'Бараниченко']);
		// print_r($query->all());
        // return $query->all();
        return $dataProvider;
    }
}
