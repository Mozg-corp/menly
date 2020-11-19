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
		$name = $this->driverAccounts[0]['name'];
		$account = $this->driverAccounts[0]['account'];
		$payload = [];
		$payload['account'] = $account;
		$payload['balance'] = $balance;
		try{
			$promise = $this->client->createTransactionByName($name, $payload);
			$response = $promise->wait();
			$this->result = $this->extractCreateFromResponse($response, $name);
		}catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
			$reasonBody = $response->getBody()->getContents();
			if($reasonBody->code === 401 && $reasonBody->message === 'Expired JWT Token'){
				$this->result = $this->createWithRefreshToken($name, $payload);
			}else{
				 
			}
		}
	}
}