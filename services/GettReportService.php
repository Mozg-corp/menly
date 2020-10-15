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
			
			$order = new \app\models\GettOrder();
			$order->fillFromRide($ride);
			$order->save();
			
			$balance = \app\models\GettBalance::find()->byDriver($ride)->one();
			if($balance){
				$balance->accumulateRide($ride);
			}else{
				$balance = new \app\models\GettBalance();
				$balance->fillFromRide($ride);
			}
			$balance->save();
		}
	}
}