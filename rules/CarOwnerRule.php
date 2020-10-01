<?php namespace app\rules;
class CarOwnerRule extends \yii\rbac\Rule{
	public $name = 'carOwnerRule';
	
	public function execute($user, $item, $params){
		$car = \yii\helpers\ArrayHelper::getValue($params, 'car');
		if(!$car){
			throw new \Exception('Car param is needed in the rule');
		}
		return $user === $car->id_users;
	}
}