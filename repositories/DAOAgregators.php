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
			$driver_uid = $account['account'];
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
		$name = $this->driverAccounts[0]['name'];
		$account = $this->driverAccounts[0]['account'];
		$payload = [];
		$payload['account'] = $account;
		$payload['balance'] = $balance;
		$promise = $this->controller->client->createTransactionByName($name, $payload);
		try{
			$response = $promise->wait();
			return $this->result = [
				"code" => 200,
				"status" => 'OK',
				"message" => 'Успешно создана заявка на вывод средств.'
			];
		}catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody()->getContents();
			//$responseStdObj = json_decode($responseBodyAsString);
			return $responseBodyAsString;
		}
	}
}