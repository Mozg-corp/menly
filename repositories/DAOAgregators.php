<?php namespace app\repositories;
abstract class DAOAgregators extends \yii\base\Model{
	protected $driverAccounts;
	protected $client;
	protected $factory;
	public $result;
	abstract protected function fetch():array;
	abstract protected function extractFromResponse($response, $name);
	abstract protected function getWithRefreshToken($name, $payload);
	public function __construct(array $driverAccounts, 
	  \app\interfaces\ClientInterface $client,
\app\interfaces\ServiceFactoryInterface $factory){
		$this->driverAccounts =  $driverAccounts;
		$this->client = $client;
		$this->factory = $factory;
		$this->result = [];
	} 
	private function send():array{
		$promises = $this->fetch();
		//settle не выдаёт ошибку на reject промиса
		$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		return $responses;
	}
	public function read(){
		$responses = $this->send();
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$payload['account'] = $account['account'];
			$statePromise = $responses[$name]['state'];
			
			if($statePromise === 'fulfilled'){
				$this->result[$name] = $this->extractFromResponse($responses[$name], $name);
			}else if($statePromise === 'rejected'){
				$rawReasonBody = $responses[$name]['reason']->getResponse()->getBody()->getContents();
				$reasonBody = json_decode($rawReasonBody);
				if($reasonBody->code === 401 && $reasonBody->message === 'Expired JWT Token'){
					$this->result[$name] = $this->getWithRefreshToken($name, $payload);
				}else{
					return $responses[$name]['reason']->getResponse();
				}
			}
		}
	}
	public function create(string $balance){
		//здесь подразумевается что в driverAccounts только один аккаунт!
		$name = $this->driverAccounts[0]['name'];
		$id_users = \Yii::$app->user->id;
		$id_agregators = $this->driverAccounts[0]['id_agregator'];
		$transferNew = new \app\models\Transfer();
		$transferNew->scenarioDriverTransfer();
		$status = \app\models\TransferStatus::find()->byStatus('Создан')->one();
		$transferArrayData = [
			'id_users' => $id_users,
			'id_agregators' => $id_agregators,
			'id_transfer_statuses' => $status->id,
			'transfer' => $balance
		];
		$transferNew->load($transferArrayData, '');
		if($transferNew->validate()){
			if($transferNew->save()){
				$this->result = $transferNew;
			}else{
				throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
			}
		}else{
			$response = \Yii::$app->getResponse();
            $response->setStatusCode(422);
			$this->result = $transferNew;
			
			//throw new \yii\web\UnprocessableEntityHttpException(json_encode($transferNew->errors), 422);
		}
		// $payload = [];
		// $payload['account'] = $account;
		// $payload['balance'] = $balance;
		// $promise = $this->client->createTransactionByName($name, $payload);
		// try{
			// $response = $promise->wait();
			// return $this->result = $response->getBody()->getContents();
			// return $this->result = [
				// "code" => 200,
				// "status" => 'OK',
				// "message" => 'Успешно создана заявка на вывод средств.'
			// ];
		// }catch(\GuzzleHttp\Exception\ClientException $e){
			// $response = $e->getResponse();
			// $responseBodyAsString = $response->getBody()->getContents();
			// $responseStdObj = json_decode($responseBodyAsString);
			// return $responseBodyAsString;
		// }
	}
}