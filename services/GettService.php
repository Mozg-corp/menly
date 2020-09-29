<?php namespace app\services;

class GettService{
	public $name = 'gett';
	public $auth;
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function loginRequest(){
		$request = new \GuzzleHttp\Psr7\Request('POST', 'https://gettpartner.ru/api/fleet/v1/auth');
		return $request;
	}
	public function loginData(){
		return ['json' => ['login' => $this->auth['login'], 'password' => $this->auth['password']]];
	}
}