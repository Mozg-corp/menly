<?php namespace app\services;
class GettReportService {
	private $rides;
	public function __construct(array $rides){
		$this->rides = $rides;
	}
	public function calculateBalances(){
		forEach($this->rides as $ride_data){
			echo 'id_driver  ' . $ride_data->driver_id;
			$ride = new \app\models\Ride();
			$ride->fillFromRideData($ride_data);
			
			if($ride->userExist()){
				echo '___user exist___';
				if($ride->exist()){
					echo '____ride exist____';
					if($ride->balanceChanged()){
						echo '____balance changed____';
						$ride->updateOrderAndBalance();
					}
					
				}else{
					echo '___new ride___';
					$ride->saveOrder();
					$ride->saveBalance();
				}
			}else{
				echo '___user NOT exist___';
			}
		}
	}
}