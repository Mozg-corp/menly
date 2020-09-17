<?php namespace app\controllers;
class UserController extends \app\controllers\BaseController{
	public $modelClass = \app\models\User::class;
	public $updateScenario = \app\models\User::SCENARIO_UPDATE;
	public $createScenario = \app\models\User::SCENARIO_CREATE;


	public function checkAccess($action, $model = null, $params=[]){
		
		if(!\Yii::$app->rbac->canAdmin()){
			throw new \yii\web\ForbiddenHttpException('You can\'t work with this user data');
		}

		return true;
	}
}