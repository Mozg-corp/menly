<?php
namespace app\services;

class HttpClientService implements \app\interfaces\ClientInterface{
	private $serviceFactory;
	private $token = [
		'value' => null,
		'expire' => null
	];
	private $client;
	public function __construct(\app\interfaces\ServiceFactoryInterface $serviceFactory, Array $opt = []){
		//parent::__construct($opt);
		$this->serviceFactory = $serviceFactory;
		$this->client = new \GuzzleHttp\Client();
	}
	public function fetch($service, string $type, array $payload = []){
		//$service = $this->serviceFactory::getServiceFactory($name);
		//print_r($service->prepearRequest($type));die;
		return $this->client->sendAsync($service->prepearRequest($type), $service->prepearData($type, $payload));
	}
	public function loginByName($service):array{
		$promise = $this->fetch($service, 'login');
		$response = $promise->wait();
		$body = json_decode($response->getBody()->getContents());
		$agregator = \app\models\Agregator::find()->getAgregatorByName($service::NAME);
		$agregator->token = isset($body->token)?$body->token:$body->access_token;
		$agregator->refresh_token = isset($body->refresh_token)?$body->refresh_token:null;
		$agregator->expire = time() + 7200;
		$agregator->save();
		
		return [ 
			'value' => $agregator->token,
			'expire' => $agregator->expire
			];
	}
	private function obtainToken($service){
		if($this->token['value'] && $this->token['expire'] -100 > time()){
			return $this->token['value'];
		}
		else{
			$agregator = \app\models\Agregator::find()->getAgregatorByName($service::NAME);
			if($agregator->token && $agregator->expire - 100 > time()){
				$this->token['value'] = $agregator->token;
				$this->token['expire'] = $agregator->expire;
				return $agregator->token;
			}else{
				$this->token = $this->loginByName($service);
				return $this->token['value'];
			}
		}
	}
	public function createGettReport(){
		$service = $this->serviceFactory::getServiceFactory('Gett');
		$token = $this->obtainToken($service);
		$promise = $this->fetch($service,'report', ["token" => $token]);
		$response = $promise->wait();
		// print_r($response);
		// echo PHP_EOL;
		$body = json_decode($response->getBody()->getContents());
		print_r($body);
	}
	public function getBalance(string $driverId){
		$service = $this->serviceFactory::getServiceFactory('Яндекс');
		$promise = $this->fetch($service,'balance', ["driverId" => $driverId]);
		$response = $promise->wait();
		$body = json_decode($response->getBody()->getContents());
		print_r($body->driver_profiles[0]->accounts[0]->balance);
	}
	// public function obtainGettBalance
}