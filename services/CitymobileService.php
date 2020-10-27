<?php namespace app\services;

class CitymobileService{
	private $auth;
	const NAME = 'Ситимобиль';
	private $uri;
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
	public function prepearRequest(string $type){
		switch($type){
			case 'login': return $this->loginRequest();
			case 'balance': return $this->balanceRequest();
		}
	}
	public function prepearData(string $type, array $payload = []){
		switch($type){
			case 'login': return $this->loginData();
			case 'balance': return $this->balanceData($payload);
		}
	}
	public function balanceRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/drivers';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function balanceData(array $payload){
		return [
			'headers' => [
				'Authorization' => 'Bearer '. $payload['token']
			],
			'json' => [
					"filter" => [
						"login" => $payload['login']
					]
					  ,
					  "sort" => []
                   ],

		];
	}
	public function getApiUri(){
		return $this->uri ? $this->uri : \app\models\Agregator::find()->getApiByName(self::NAME);
	}
	public static function extractBalanceFromBody($body){
		return $body->drivers[0]->full_balance;
	}
	public static function extractBalanceFromResponse($response){
		$body = $response['value']->getBody()->getContents();
		return self::extractBalanceFromBody(json_decode($body));
	}
}