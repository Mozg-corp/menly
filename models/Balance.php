<?php namespace app\models;
class Balance extends \yii\base\Model{
	private $driverAccounts;
	private $client;
	private $factory;
	public $balances;
	public function __construct(array $driverAccounts, 
						\app\interfaces\ClientInterface $client, 
						\app\interfaces\ServiceFactoryInterface $factory){
		$this->driverAccounts =  $driverAccounts;
		$this->client = $client;
		$this->factory = $factory;
		$this->balances = [];
	}
	public function fields(){
		return [
			'balances'
		];
	}
	public function getBalances():array{
		if(count($this->balances)===0){
			$this->requestBalances();
		}
		return $this->balances;
	}
	private function fetchBalances():array{
		$promises = [];
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$driver_uid = $account['account'];
			$promises[$name] = $this->client->getBalanceByName($name, $driver_uid);			
		}
		return $promises;
	}
	private function obtainBalances():array{
		$promises = $this->fetchBalances();
		$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		return $responses;
	}
	public function requestBalances(){
		$responses = $this->obtainBalances();
		$balances = [];
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$driver_uid = $account['account'];
			$staticService = $this->factory->getClassByName($name);
			$statePromise = $responses[$name]['state'];
			
			if($statePromise === 'fulfilled'){
				$this->balances[$name] = $staticService::extractBalanceFromResponse($responses[$name]);
			}else if($statePromise === 'rejected'){
				$rawReasonBody = $responses[$name]['reason']->getResponse()->getBody()->getContents();
				$reasonBody = json_decode($rawReasonBody);
				if($reasonBody->code === 401 && $reasonBody->message === 'Expired JWT Token'){
					$this->balances[$name] = $this->getBalanceWithRefreshToken($name, $driver_uid);

				}
			}
		}
	}
	private function getBalanceWithRefreshToken(string $name, string $driver_uid){
		$agregator = \app\models\Agregator::find()->getAgregatorByName($name);
		$agregator->flushToken();
		
		$promise = $this->client->getBalanceByName($name, $driver_uid);
		$response = $promise->wait();
		$body = $response->getBody()->getContents();
		$balance = $staticService::extractBalanceFromBody(json_decode($body));
		return balance;
	}
}