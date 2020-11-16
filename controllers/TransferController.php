<?php namespace app\controllers;

class TransferController extends \app\controllers\BaseController{
	public $modelClass = \app\models\Transfer::class;
	public $updateScenario = \app\models\Transfer::SCENARIO_UPDATE;
	public $createScenario = \app\models\Transfer::SCENARIO_CREATE;
	public function actions(){
		$actions = parent::actions();
		$actions['create'] = [
			'class' => \app\controllers\actions\transfer\CreateAction::class,
			'modelClass' => $this->modelClass,
			'checkAccess' => [$this, 'checkAccess']
		];
		return array_merge([
			'alltransfers' => [
				'class' => \app\controllers\actions\transfer\AllOwnTransfersAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			]
		], $actions);
	}
	public function checkAccess($action, $model = null, $params = []){
		// if(\Yii::$app->rbac->canAdmin())return true;
		switch($action){
			case 'index': 
				if(!\Yii::$app->user->can('viewAllTransfers')){
					throw new \yii\web\ForbiddenHttpException('You can see only your own transfers');
				}
				break;
			case 'view':
				if(!\Yii::$app->user->can('viewOwnTransfers', ['transfer' => $model])){
					throw new \yii\web\ForbiddenHttpException('It\'s not your transfer');
				}
				break;
			case 'update':
				if(!\Yii::$app->user->can('updateAnyTransfer')){
					throw new \yii\web\ForbiddenHttpException('You cann\'t update transfer');
				}
				break;
		}
		return true;
	}
}