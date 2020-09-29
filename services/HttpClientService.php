<?php
namespace app\services;

class HttpClientService extends \GuzzleHttp\Client {
	public $agregatorServices;
	public function __construct(Array $agregatorServices, Array $opt = []){
		parent::__construct($opt);
		$this->agregatorServices = $agregatorServices;
	}
	public function loginAll(){
		$promises = [
			'citymobile' => parent::sendAsync(($this->agregatorServices['citymobile'])->loginRequest(), ($this->agregatorServices['citymobile'])->loginData()),
			'gett' => parent::sendAsync(($this->agregatorServices['gett'])->loginRequest(), ($this->agregatorServices['gett'])->loginData()),
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