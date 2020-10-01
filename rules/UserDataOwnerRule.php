<?php namespace app\rules;
class UserDataOwnerRule extends \yii\rbac\Rule{
	public $name = 'UserDataOwnerRule';
	
	public function execute($user, $item, $params){
		$user = \yii\helpers\ArrayHelper::getValue($params, 'user');
		if(!car){
			throw new \Exception('User param is needed in the rule');
		}
		return $user === $user->id;
	}
}