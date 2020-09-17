<?php namespace app\controllers;
class CarController extends \app\controllers\BaseController{
	public $modelClass = \app\models\Car::class;
	public $updateScenario = \app\models\Car::SCENARIO_UPDATE;
	public $createScenario = \app\models\Car::SCENARIO_CREATE;
	
	public function checkAccess($action, $model = null, $params = []){
		switch($action){
			case 'index': 
				if(!\Yii::$app->user->can('viewAllCars')){
					throw new \yii\web\ForbiddenHttpException('You can see only your own car');
				}
				break;
			case 'view':
				if(!\Yii::$app->user->can('viewOwnCar', [ 'car' => $model])){
					throw new \yii\web\ForbiddenHttpException('It\'s not your car');
				}
				break;
			case 'create':
				break;
			case 'update':
				if(!\Yii::$app->user->can('updateAnyCar')){
					throw new \yii\web\FobiddenHttpException('You cann\'t update car');
				}
				break;
		}
		return true;
	}
}