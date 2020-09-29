<?php namespace app\services;

class CitymobileService{
	public $auth;
	public $name = 'citymobile';
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function loginRequest(){
		$request =  new \GuzzleHttp\Psr7\Request('POST', 'https://fleet.city-mobil.ru/api/1.0/user/identity');
		return $request;
	}
	public function loginData(){
		return ['json' => ['login' => $this->auth['login'], 'password' => $this->auth['password']]];
	}
	
}