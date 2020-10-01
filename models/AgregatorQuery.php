<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AgregatorBase]].
 *
 * @see AgregatorBase
 */
class AgregatorQuery extends \app\models\AgregatorBaseQuery
{

	public function getApies(){
		return $this->select(['name', 'apiv1', 'apiv2'])->all();
	}
	public function getAgregatorByName(string $name):?\app\models\Agregator{
		return $this->where(['name' => $name])->one();
	}
}
