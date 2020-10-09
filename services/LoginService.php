<?php namespace app\services;
// class LoginService implements \app\interfaces\LoginInterface{
	// private $client;
	// public function __construct(\app\interfaces\ClientInterface $client){
		// $this->client = $client;
	// }
	// public function loginAll(array $agregatorsNames):array{
		// $promises = [];
		// $loginData = [];
		// forEach($agregatorsNames as $agregatorName){
			// $agregator = \app\models\Agregator::find()->getAgregatorByName($agregatorName);
			// if($agregator->token && $agregator->expire > time()){
				// $loginData[$agregatorName] = $agregator->token;
			// }else{
				// $promises[$agregatorName] = $this->client->loginAgregator($agregatorName);
			// }
		// }
		// $responses = \GuzzleHttp\Promise\settle($promises)->wait();
		// forEach($agregatorsNames as $agregatorName){
			// if(array_key_exists($agregatorName, $loginData)){
				// continue;
			// }else{
				// $body = json_decode($responses[$agregatorName]['value']->getBody()->getContents());
				// $agregator = \app\models\Agregator::find()->getAgregatorByName($agregatorName);;
				// $agregator->token = isset($body->token)?$body->token:$body->access_token;
				// $agregator->refresh_token = isset($body->refresh_token)?$body->refresh_token:null;
				// $agregator->expire = time() + 7200;
				// $agregator->save();
				// $loginData[$agregatorName] =  $agregator->token;
			// }
		// }
		// return $loginData;
	// }
	// public function loginByName(string $agregatorName):string{
		// $loginData = [];
		// $agregator = \app\models\Agregator::find()->getAgregatorByName($agregatorName);
		// if($agregator->token && $agregator->expire > time()){
			// return $agregator->token;
		// }else{
			// $promise = $this->client->loginAgregator($agregatorName);
			// $response = \GuzzleHttp\Promise\settle($promise)->wait();
			// $body = json_decode($response[0]['value']->getBody()->getContents());
			// $agregator->token = isset($body->token)?$body->token:$body->access_token;
			// $agregator->refresh_token = isset($body->refresh_token)?$body->refresh_token:null;
			// $agregator->expire = time() + 7200;
			// $agregator->save();
			// return $agregator->token;
		// }
	// }
// }