<?php namespace app\controllers;
class UserAgregatorController extends \app\controllers\BaseController{
	public $modelClass = \app\models\UserAgregator::class;
	public $updateScenario = \app\models\UserAgregator::SCENARIO_UPDATE;
	public $createScenario = \app\models\UserAgregator::SCENARIO_CREATE;
	
	public function checkAccess($action, $model = null, $param = []){
		switch($action){
			case 'create': 
				break;
			default:
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You cann\'t work with this user-agregator relation data');
				}
		}
		return true;
	}
}