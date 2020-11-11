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
	//Вместо этого метода нужно использовать byName
	public function getAgregatorByName(string $name):?\app\models\Agregator{
		return $this->where(['name' => $name])->one();
	}
	public function getApiByName(string $name):string{
		return $this->select(['apiv1'])->where(['name' => $name])->one()->apiv1;
	}
	public function getApiV2ByName(string $name):string{
		return $this->select(['apiv2'])->where(['name' => $name])->one()->apiv2;
	}
	public function byName(string $name):\yii\db\ActiveQuery{
		return $this->where(['name' => $name]);
	}
}
