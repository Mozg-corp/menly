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
	public function prepearRequest(string $type, array $payload = []){
		switch($type){
			case 'login': return $this->loginRequest();
			case 'balance': return $this->balanceRequest();
			case 'transactions' : return $this->transactionsRequest();
			case 'transfer': {
				if((float) $payload['balance'] > 0){
					return $this->transferAddRequest();
				}else{
					return $this->transferSubRequest();
				}
			}
		}
	}
	public function prepearData(string $type, array $payload = []){
		switch($type){
			case 'login': return $this->loginData();
			case 'balance': return $this->balanceData($payload);
			case 'transactions' : return $this->transactionsData($payload);
			case 'transfer': return $this->transferData($payload);
		}
	}
	public function balanceRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/driver/payments';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function balanceData(array $payload){
		$date = new \Datetime();
		$date->setTimezone(new \DateTimeZone('Europe/Moscow'));
		return [
			'headers' => [
				'Authorization' => 'Bearer '. $payload['token']
			],
			'json' => [
					"driver_uuid" => $payload['login'],
					"filter" => [
						"date_begin" => $date,
						"date_end" => $date
					]
					  ,
					  "sort" => []
                   ],

		];
	}
	public function getApiUri(){
		return $this->uri ? $this->uri : \app\models\Agregator::find()->getApiByName(self::NAME);
	}
	public function transactionsRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/driver/payments';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function transferAddRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/driver/createAccrualChargePayment';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function transferSubRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/driver/createDebitChargePayment';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function transferData($payload){
		return [
			'headers' => [
				'Authorization' => 'Bearer '. $payload['token']
			],
			'json' => [
					"driver_uuid" => $payload['account'],
					"fields" => [
						"payment" => (float) $payload['balance']
					]
             ],

		];
	}
	public function transactionsData($payload){
		$date = new \DateTime();
		// $date->setTimezone(new \DateTimeZone('Europe/Moscow'));
		$to = $date->format('c');
		$date->sub(new \DateInterval("P30D"));
		$from = $date->format('c');
		$payload['to'] = $to;
		$payload['from'] = $from;
		return [
			'headers' => [
				'Authorization' => 'Bearer '. $payload['token']
			],
			'json' => [
					"driver_uuid" => $payload['account'],
					"filter" => [
						"id_type" => [62,82,84,90,92,64,814],
						"date_begin" => $payload['from'],
						"date_end" => $payload['to']
					]
					  ,
					  "sort" => []
                   ],

		];
	}
	public static function extractBalanceFromBody($body){
		return $body->all_balance;
	}
	public static function extractBalanceFromResponse($response){
		$body = $response['value']->getBody()->getContents();
		return self::extractBalanceFromBody(json_decode($body));
	}
	public static function extractTransactionsFromBody($body){
		// print_r($body);die;
		$transactions = [];
		forEach($body->payments as $payment){
			array_push($transactions,[
				'agregator' => self::NAME,
				'type' => $payment->type_name,
				'balance' => $payment->sum,
				'date' => (new \DateTime($payment->oppdate))->format('d.m.Y H:m')
			]);
		}
		return $transactions;
	}
	public static function extractTransactionsFromResponse($response){
		$body = $response['value']->getBody()->getContents();
		return self::extractTransactionsFromBody(json_decode($body));
	}
	public static function extractCreateTransactionResultFromResponse($response){
		$body = $response->getBody()->getContents();
		return self::extractCreateTransactionResultFromBody(json_decode($body));
	}
	public static function extractCreateTransactionResultFromBody($body){
		$agregator_transfer_id = $body->id_payment;
		return $agregator_transfer_id;
	}
	
}