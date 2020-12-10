<?php namespace app\controllers;
class BankTransferController extends BaseController{
	public $modelClass = \app\models\Transfer::class;
	public function actions(){
		return array_merge([
			'do' => [
				'class' => \app\controllers\actions\banktransfer\CreateAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			]
		], parent::actions());
	}
	public function checkAccess($action, $model = null, $params = []){
		// if(\Yii::$app->rbac->canAdmin())return true;
		switch($action){
			case 'do':
				if(!\Yii::$app->user->can('updateAnyTransfer')){
					throw new \yii\web\ForbiddenHttpException('You cann\'t create bank transfers');
				}
				break;
		}
		return true;
	}
}