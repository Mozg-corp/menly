<?php namespace app\services;

class YandexService{
	private $auth;
	private $uri;
	const NAME = 'Яндекс';
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function prepearRequest(string $type){
		switch($type){
			case 'balance': return $this->balanceRequest();
		}
	}
	public function prepearData(string $type, $payload = []){
		switch($type){
			case 'balance': return $this->balanceData($payload);
		}
	}
	public function balanceRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/parks/driver-profiles/list';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function getApiUri(){
		return $this->uri ? $this->uri : \app\models\Agregator::find()->getApiByName(self::NAME);
	}
	public function balanceData(array $payload){
		$idempotency = isset($payload['idempotency'])? $payload['idempotency'] : false;
		return [
			'headers' => $this->getHeaders($idempotency),
			'json' => [
                        'query' => [
                            'park' => [
                                'id' => $this->auth['parkId'],
                                'driver_profile' => [
                                    'id' => [
                                        $payload['driverId']
                                    ]
                                ]
                            ]
                        ]
                    ],

		];
	}
	private function getHeaders(bool $idempotency = false): array
    {
        if ($idempotency) {
            return [
                'X-Client-ID' => $this->auth['clientID'],
                'X-Api-Key' => $this->auth['apiKey'],
                'X-Idempotency-Token' => \Ramsey\Uuid\Uuid::uuid4()->toString()
            ];
        } else {
            return [
                'X-Client-ID' => $this->auth['clientID'],
                'X-Api-Key' => $this->auth['apiKey']
            ];
        }
    }
	public static function extractBalanceFromBody($body){
		return $body->driver_profiles[0]->accounts[0]->balance;
	}
}