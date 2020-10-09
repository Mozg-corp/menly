<?php namespace app\commands;
class BalanceController extends \yii\console\Controller{
	private $loginService;
	public function __construct($id, $module, $loginService, $config=[]){
		parent::__construct($id, $module, $config);
		$this->loginService - $loginService;
	}
	
	public function actionGett(){
		
	}
}