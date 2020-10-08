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
		return $this->select(['name', 'apiv1', 'apiv2'])->asArray()->all();
	}
	public function getAgregatorByName(string $name):?\app\models\Agregator{
		return $this->where(['name' => $name])->one();
	}
	public function getApiByName(string $name):string{
		return $this->select(['apiv1'])->where(['name' => $name])->one()->apiv1;
	}
}
