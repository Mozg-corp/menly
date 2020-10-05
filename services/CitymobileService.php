<?php namespace app\services;

class CitymobileService{
	public $auth;
	const NAME = 'Ситимобиль';
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function loginRequest(){
		$api_url = \app\models\Agregator::find()->getApiByName('Ситимобиль');
		$auth_url = $api_url . '/user/identity';
		$request =  new \GuzzleHttp\Psr7\Request('POST', $auth_url);
		return $request;
	}
	public function loginData(){
		return ['json' => ['login' => $this->auth['login'], 'password' => $this->auth['password']]];
	}
	
}