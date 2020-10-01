<?php
namespace app\services;

class HttpClientService extends \GuzzleHttp\Client {
	public $agregatorServices;
	public $agregatorsApies;
	public function __construct(Array $agregatorServices, Array $apies, Array $opt = []){
		parent::__construct($opt);
		$this->agregatorServices = $agregatorServices;
		$this->agregatorsApies = \app\models\Agregator::find()->Apies;
	}
	public function loginAll(){
		// $city_api = $this->agregatorsApies->where(['name' => 'Ситимобиль'])->one()->apiv1;
		// $gett_api = $this->agregatorsApies->where(['name' => 'Gett'])->one()->apiv1;
		$city_api = array_values(array_filter($this->agregatorsApies, function($el){
			return $el->name === \app\services\CitymobileService::NAME;
		}))[0];
		$gett_api = array_values(array_filter($this->agregatorsApies, function($el){
			return $el->name === \app\services\GettService::NAME;
		}))[0];
		$promises = [
			\app\services\CitymobileService::NAME => parent::sendAsync(($this->agregatorServices[\app\services\CitymobileService::NAME])->loginRequest($city_api->apiv1), ($this->agregatorServices[\app\services\CitymobileService::NAME])->loginData()),
			\app\services\GettService::NAME => parent::sendAsync(($this->agregatorServices[\app\services\GettService::NAME])->loginRequest($gett_api->apiv1), ($this->agregatorServices[\app\services\GettService::NAME])->loginData()),
		];
		$results =  \GuzzleHttp\Promise\settle($promises)->wait();
		// return [$results['citymobile']['value'], $results['gett']['value']];
		return $results;
		// print_r($this->agregatorServices->loginRequest());
			// return parent::send($this->agregatorServices->loginRequest());
			//return parent::send($this->agregatorServices->loginRequest(), $this->agregatorServices->loginData());
			// return $this->agregatorServices->loginRequest();
	}
}