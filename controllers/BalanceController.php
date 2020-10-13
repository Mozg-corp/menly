<?php namespace app\controllers;
class BalanceController extends BaseController{
	public $modelClass = \app\models\User::class;
	public $client;
	public function __construct($id, $module, \app\interfaces\ClientInterface $client, $config = []){
		$this->client = $client;
		parent::__construct($id, $module, $config);
	}
	// public function behaviors(){}
	
	public function actions(){
		return [
			'view' => [
				'class' => \app\controllers\actions\balance\ViewAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			],
            'citymobile' => [
                'class' => \app\controllers\actions\balance\CitymobileAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ]
		];
	}
	public function checkAccess($action, $model = null, $params=[]){
		//throw new \yii\web\ForbiddenHttpException('It\'s not your profile'); 
		
	}
}