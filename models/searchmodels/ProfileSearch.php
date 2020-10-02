<?php

namespace app\models\searchmodels;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProfileBase;

/**
 * ProfileSearch represents the model behind the search form of `app\models\ProfileBase`.
 */
class ProfileSearch extends ProfileBase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['firstname', 'secondname', 'lastname', 'phone', 'birthdate', 'passport_series', 'passport_number', 'passport_giver', 'passport_date', 'registration_address', 'license_series', 'license_number', 'license_date', 'license_expire', 'uuid', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = ProfileBase::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birthdate' => $this->birthdate,
            'passport_date' => $this->passport_date,
            'license_date' => $this->license_date,
            'license_expire' => $this->license_expire,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'secondname', $this->secondname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'passport_series', $this->passport_series])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'passport_giver', $this->passport_giver])
            ->andFilterWhere(['like', 'registration_address', $this->registration_address])
            ->andFilterWhere(['like', 'license_series', $this->license_series])
            ->andFilterWhere(['like', 'license_number', $this->license_number])
            ->andFilterWhere(['like', 'uuid', $this->uuid]);

        return $dataProvider;
    }
}
