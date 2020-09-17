<?php namespace app\controllers;
class AgregatorController extends \app\controllers\BaseController{
	public $modelClass = \app\models\Agregator::class;
	public $updateScenario = \app\models\Agregator::SCENARIO_UPDATE;
	public $createScenario = \app\models\Agregator::SCENARIO_CREATE;
	public function behaviors(){
        $behaviors = parent::behaviors();
		$behaviors['authentication']['except'] = ['index', 'view'];
        return $behaviors;
    }
	public function checkAccess($action, $model = null, $params = []){
		switch($action){
			case 'create':
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You can\'t create agregators');
				}
				break;
			case 'update':
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You can\'t change agregators');
				}
				break;
		}
		return true;
	}
}