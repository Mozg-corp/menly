<?php namespace app\services;
class BalanceService {
	private $loginService;
	public function __construct(\app\services\LoginService $loginService){
		$this->loginService = $loginService;
	}
	public function fetchGettReport(){
		$token = $this->loginService->login('Gett');
		
	}
	public static function extructBalances(array $arrayRides){
		$balance = [];
        foreach ($arrayRides as $ride) {
			if(array_key_exists($ride->driver_id, $balance)){
				$balance[$ride->driver_id] += $ride->driver_order_balance + $ride->driver_tips; 
			}else{
				$balance[$ride->driver_id] = $ride->driver_order_balance + $ride->driver_tips;
			}
		}
		return $balance;
	}
}