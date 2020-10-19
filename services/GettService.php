<?php namespace app\services;

class GettService{
	const NAME = 'Gett';
	private $auth;
	private $uri;
	public function __construct(Array $auth = []){
		$this->auth = $auth;
	}
	public function prepearRequest(string $type){
		switch($type){
			case 'login': return $this->getLoginRequest();
			case 'reportCreate': return $this->createReportRequest();
			case 'reportRead': return $this->readReportRequest();
		}
	}
	public function prepearData(string $type, array $payload = []){
		switch($type){
			case 'login': return $this->loginData();
			case 'reportCreate': return $this->createReportData($payload);
			case 'reportRead': return $this->readReportData($payload);
		}
	}
	public function getLoginRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/auth';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function createReportRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/dbr/create';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function readReportRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/dbr/get';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function loginData(){
		return ['json' => ['login' => $this->auth['login'], 'password' => $this->auth['password']]];
	}
	public function getApiUri(){
		return $this->uri ? $this->uri : \app\models\Agregator::find()->getApiByName('Gett');
	}
	public function createReportData(array $payload){
		
		return ['headers' => [
			'Authorization' => 'Bearer '. $payload['token']
		],
			'json' => [
				'from' => $payload['from'], 
				'to' => $payload['to']
			]
		];
	}
	public function readReportData(array $payload){
		return ['headers' => [
			'Authorization' => 'Bearer '. $payload['token']
		],
			'json' => ['uid' => $payload['uid']]
		];
	}
	public static function extractBalanceFromResponse($response){
		$balance = $response['value']->balance;
		$tips = $response['value']->tips;
		$parking_cost = $response['value']->parking_cost;
		$total_gross = $balance + $tips - $parking_cost;
		$agregator_commition = 0.198;
		return $total_gross - ($total_gross)* $agregator_commition;
	}
}