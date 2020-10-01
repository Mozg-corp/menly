<?php namespace app\services;

class GettService{
	const NAME = 'Gett';
	public $auth;
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function loginRequest($api_url){
		$auth_url = $api_url . '/auth';
		$request = new \GuzzleHttp\Psr7\Request('POST', $auth_url);
		return $request;
	}
	public function loginData(){
		return ['json' => ['login' => $this->auth['login'], 'password' => $this->auth['password']]];
	}
}