<?php namespace app\services;

class YandexService{
	private $auth;
	private $uri;
	private $uriV2;
	const NAME = 'Яндекс';
	public function __construct(Array $auth){
		$this->auth = $auth;
	}
	public function prepearRequest(string $type){
		switch($type){
			case 'balance': return $this->balanceRequest();
			case 'transactions': return $this->transactionsRequest();
		}
	}
	public function prepearData(string $type, $payload = []){
		switch($type){
			case 'balance': return $this->balanceData($payload);
			case 'transactions': return $this->transactionsData($payload);
		}
	}
	public function balanceRequest(){
		$api_url = $this->getApiUri();
		$path = $api_url . '/parks/driver-profiles/list';
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function transactionsRequest(){
		$api_url = $this->getApiV2Uri();
		$path = $api_url . '/parks/driver-profiles/transactions/list';
		// print_r($path);die;
		$request = new \GuzzleHttp\Psr7\Request('POST', $path);
		return $request;
	}
	public function transactionsData(array $payload){
		$idempotency = isset($payload['idempotency'])? $payload['idempotency'] : false;
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Europe/Moscow'));
		$to = $date->format('c');
		$date->sub(new \DateInterval("P180D"));
		$from = $date->format('c');
		$payload['to'] = $to;
		$payload['from'] = $from;
		return [
			'headers' => $this->getHeaders($idempotency),
			'json' => [
				"limit" => 100,
				'query' => [
					'park' => [
						'id' => $this->auth['parkId'],
						'driver_profile' => [
							'id' => $payload['account']
							
						],
						"transaction" => [
							"category_ids" => [
								"partner_service_recurrent_payment",
								"partner_service_recurring_payment_cancellation",
								"partner_service_recurring_payment",
								"partner_service_other",
								"partner_service_financial_statement",
								"partner_service_manual",
								"partner_service_manual_1",
								"partner_service_manual_2",
								"partner_service_manual_3",
								"partner_service_manual_4"
							],
							"event_at" => [
								"from" => $payload['from'],
								"to" => $payload['to']
							]
						]
					]
				]
			],

		];
	}
	public function getApiUri(){
		return $this->uri ? $this->uri : \app\models\Agregator::find()->getApiByName(self::NAME);
	}
	public function getApiV2Uri(){
		return $this->uriV2 ? $this->uriV2 : \app\models\Agregator::find()->getApiV2ByName(self::NAME);
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
	public static function extractBalanceFromResponse($response){
		$body = $response['value']->getBody()->getContents();
		return self::extractBalanceFromBody(json_decode($body));
	}
	public static function extractTransactionsFromBody($body){
		$transactions = [];
		forEach($body->transactions as $payment){
			array_push($transactions,[
				'agregator' => self::NAME,
				'type' => $payment->description,
				'balance' => $payment->amount,
				'date' => (new \DateTime($payment->event_at))->format('d.m.Y H:m')
			]);
		}
		
		return $transactions;
	}
	public static function extractTransactionsFromResponse($response){
		$body = $response['value']->getBody()->getContents();
		return self::extractTransactionsFromBody(json_decode($body));
	}
}