<?php namespace app\services;
class GettReportService {
	private $rides;
	public function __construct(array $rides){
		$this->rides = $rides;
	}
	public function calculateBalances(){
		forEach($this->rides as $ride_data){
			echo 'id_driver  ' . $ride_data->driver_id .PHP_EOL;
			$ride = new \app\models\Ride();
			$ride->fillFromRideData($ride_data);
			
			if($ride->userExist()){
				echo '___user exist___';
				if($ride->exist()){
					echo '++++++ride exist++++++';
					if($ride->balanceChanged()){
						echo '============balance changed===========';
						$ride->updateOrderAndBalance();
					}else{
						echo '!!!!!!!!balance NOT changed!!!!!!!';
					}
					
				}else{
					echo '???????new ride?????????';
					$ride->saveOrder();
					$ride->saveBalance();
				}
			}else{
				echo '___user NOT exist___';
			}
		}
	}
}