<?php namespace app\controllers;
class AccountController extends BaseController{
	public $modelClass = \app\models\DriverAccount::class;
	public $updateScenario = \app\models\DriverAccount::SCENARIO_UPDATE;
	public $createScenario = \app\models\DriverAccount::SCENARIO_CREATE;
	
	public function checkAccess($action, $model=null, $params=[]){
		if(\Yii::$app->rbac->canAdmin()){
			return true;
		}
		throw new \yii\web\ForbiddenHttpException('Only administrator has access');
	}
}