<?php namespace app\services;
class GettReportService {
	private $rides;
	public function __construct(array $rides){
		$this->rides = $rides;
	}
	public function calculateBalances(){
		forEach($this->rides as $ride_data){
			
			$ride = new \app\models\Ride();
			$ride->fillFromRideData($ride_data);
			
			if($ride->userExist()){
				//echo 'user exist';
				if($ride->exist()){
					// echo 'ride exist';
					if($ride->balanceChanged()){
						// echo 'balance changed';
						$ride->updateOrderAndBalance();
					}
					
				}else{
					$ride->saveOrder();
					$ride->saveBalance();
				}
			}
		}
	}
}