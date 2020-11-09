<?php namespace app\repositories;
class DAOBalance extends DAOAgregators{
	
	public function __construct(array $driverAccounts, 
						\app\interfaces\ClientInterface $client, 
						\app\interfaces\ServiceFactoryInterface $factory){
	
		parent::__construct($driverAccounts, $client, $factory);
	}
	public function fetch():array{
		$promises = [];
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$driver_uid = $account['account'];
			$promises[$name] = $this->client->getBalanceByName($name, $driver_uid);			
		}
		return $promises;
	}
	protected function extractFromResponse($response, $name){
		$staticService = $this->factory->getClassByName($name);
		return $staticService::extractBalanceFromResponse($response);
	}
	protected function getWithRefreshToken($name, $payload){
		
	}
}