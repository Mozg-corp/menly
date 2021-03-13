<?php
namespace app\services;
use app\models\DriverAccount;
use GuzzleHttp\Psr7;

class HttpClientService implements \app\interfaces\ClientInterface{
	private $serviceFactory;
	private $token = [
		'value' => null,
		'expire' => null
	];
	private $client;
	public function __construct(\app\interfaces\ServiceFactoryInterface $serviceFactory){
		$this->serviceFactory = $serviceFactory;
		$this->client = new \GuzzleHttp\Client();
	}
	public function fetch($service, string $type, array $payload = []){
		// print_r(json_encode($service->prepearData($type, $payload)));die;
		// print_r($service->prepearRequest($type, $payload));die;
		return $this->client->sendAsync($service->prepearRequest($type, $payload), $service->prepearData($type, $payload));
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
		if($this->token['value'] && $this->token['expire'] - 500 > time()){
			return $this->token['value'];
		}
		else{
			$agregator = \app\models\Agregator::find()->getAgregatorByName($service::NAME);
			if($agregator->token && $agregator->expire - 500 > time()){
				$this->token['value'] = $agregator->token;
				$this->token['expire'] = $agregator->expire;
				return $agregator->token;
			}else{
				$this->token = $this->loginByName($service);
				return $this->token['value'];
			}
		}
	}
	//Запрос на создание отчёта в Gett
	public function createGettReport($from, $to){
		$service = $this->serviceFactory::getServiceFactory('Gett');
		$token = $this->obtainToken($service);

		return $this->fetch($service,'reportCreate', [
			"token" => $token,
			"from" => $from,
			"to" => $to
		]);
	}
	//Запрос на получение отчёта в Gett
	public function readGettReport($uid){
		$service = $this->serviceFactory::getServiceFactory('Gett');
		$token = $this->obtainToken($service);
		return $this->fetch($service,'reportRead', ["token" => $token, "uid" => $uid]);
	}
	/**
	* Получение баланса водителя яндекс
	* @param string $driverId
	*/
	public function getYandexBalance(string $driverId){
		$service = $this->serviceFactory::getServiceFactory('Яндекс');
		return $this->fetch($service,'balance', ["driverId" => $driverId]);
	}
	/**
	* Получение баланса водителя в ситимобиле
	* @param string $login
	*/
	public function getCityBalance(string $login){
		$service = $this->serviceFactory::getServiceFactory('Ситимобиль');
		$token = $this->obtainToken($service);
		return $this->fetch($service,'balance', ["token" => $token, "login" => $login,]);
	}
	public function getBalanceByName(string $name, string $account){
		switch($name){
			case 'Ситимобиль': return $this->getCityBalance($account);
			case 'Яндекс': return $this->getYandexBalance($account);
			case 'Gett': return $this->getGettBalance($account);
		}
	}
	public function getGettBalance($id_driver){
		$promise =  new \GuzzleHttp\Promise\Promise();
		$balance = \app\models\GettBalance::find()->byDriverId($id_driver)->one();
		$promise->resolve($balance->balance);
		return $promise;
	}
	public function getTransactionsByName(string $name, array $payload){
		switch($name){
			case 'Яндекс': return $this->getYandexTransactions($payload);
			case 'Ситимобиль': return $this->getCityMobileTransactions($payload);
			case 'Gett': return $this->getGettTransactions($payload);
		}
	}
	public function gettGettTransactions(array $payload){
		$promise = new \GuzzleHttp\Promise\Promise();
		$transactions = [];
		$promise->resolve($transactions);
		return $promise;
	}
	public function getYandexTransactions(array $payload){
		$service = $this->serviceFactory::getServiceFactory('Яндекс');
		return $this->fetch($service, 'transactions', $payload);
	}
	public function getCityMobileTransactions(array $payload){
		$service = $this->serviceFactory::getServiceFactory('Ситимобиль');
		$token = $this->obtainToken($service);
		$payload['token'] = $token;
		return $this->fetch($service, 'transactions', $payload);
	}
	public function createTransactionByName(string $name, array $payload){
		switch($name){
			case 'Яндекс': return $this->createTransactionYandex($payload);
			case 'Ситимобиль': return $this->createTransactionCitymobile($payload);
            case 'Gett': return $this->createTransactionGett($payload);
		}
	}
	public function createTransactionYandex($payload){
		$service = $this->serviceFactory::getServiceFactory('Яндекс');
		return $this->fetch($service, 'transfer', $payload);
	}
	public function createTransactionCitymobile($payload){
		$service = $this->serviceFactory::getServiceFactory('Ситимобиль');
		$token = $this->obtainToken($service);
		$payload['token'] = $token;
		return $this->fetch($service, 'transfer', $payload);
	}
	public function createTransactionGett($payload){
        $promise =  new \GuzzleHttp\Promise\Promise();
        $account = $payload['account'];
        $transferBalance = $payload['balance'];
        $driverAccount = DriverAccount::find()->byAccount($account);
        $balance = \app\models\GettBalance::find()->byDriverId($driverAccount->id_agregator)->one();
        if ($balance->transfer($transferBalance)) {
            $promise->resolve($balance->balance);
        } else {
            $promise->reject($balance->errors);
        }
        return $promise;
    }
}
