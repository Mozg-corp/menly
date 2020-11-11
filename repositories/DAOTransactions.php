<?php namespace app\repositories;
class DAOTransactions extends DAOAgregators{
	
	public function __construct(array $driverAccounts, 
						\app\interfaces\ClientInterface $client, 
						\app\interfaces\ServiceFactoryInterface $factory){
	
		parent::__construct($driverAccounts, $client, $factory);
	}
	public function fetch():array{
		$promises = [];
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$payload = [];
			$id_driver = $account['account'];
			$payload['account'] = $id_driver;
			$promises[$name] = $this->client->getTransactionsByName($name, $payload);			
		}
		return $promises;
	}
	protected function extractFromResponse($response, $name){
		$staticService = $this->factory->getClassByName($name);
		return $staticService::extractTransactionsFromResponse($response);
	}
	protected function getWithRefreshToken($name, $payload){
		$agregator = \app\models\Agregator::find()->byName($name)->cache(600)->one();
		$agregator->flushToken();
		$promise = $this->client->getTransactionsByName($name, $payload);
		$response = $promise->wait();
		$body = $response->getBody()->getContents();
		$transaction[$name] = $staticService::extractBalanceFromBody(json_decode($body));

	}
	public function getAsArray(){
		$totalTransactions = [];
		forEach($this->result as $agregatorTransactions){
			forEach($agregatorTransactions as $transaction){
					$totalTransactions[] = $transaction;
			}
		}
		return $totalTransactions;
	}
	public function getSortedByDate(){
		$sortedTransactions = $this->asArray;
		uasort($sortedTransactions, function($left, $right){
			$prev = new \Datetime($left['date']);
			$next = new \Datetime($right['date']);
			if($prev == $next) return 0;
			return $prev < $next;
		});
		return $sortedTransactions;
	}
}