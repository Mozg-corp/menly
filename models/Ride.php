<?php namespace app\models;
class Ride extends \yii\base\Model{
	private $id_ride;
	private $id_driver;
	private $cost_for_driver_wo_tips;
	private $parking_cost;
	private $collected_from_client;
	private $driver_tips;
	
	public function fillFromRideData($ride_data){
		$costForDriver = (float)( $ride_data->cost_for_driver_wo_tips?? 0.0);
		$parkingCost = (float) ($ride_data->parking_cost?? 0.0);
		$collectedFromClient = (float) ($ride_data->collected_from_client?? 0.0);
		$driverTips = (float) ($ride_data->driver_tips?? 0.0);
		
		$this->id_ride = $ride_data->order_id;
		$this->id_driver = (string)$ride_data->driver_id;
		$this->cost_for_driver_wo_tips = $costForDriver;
		$this->parking_cost = $parkingCost;
		$this->collected_from_client = $collectedFromClient;
		$this->driver_tips = $driverTips;
	}
	public function calculateTax(){
		$costForDriver = $this->cost_for_driver_wo_tips;
		$collectedFromClient = $this->collected_from_client;
		return $costForDriver - $collectedFromClient;
	}
	public function getTips(){
		return $this->driver_tips;
	}
	public function getParkingCost(){
		return $this->parking_cost;
	}
	public function getId_driver(){
		return $this->id_driver;
	}
	public function getId_ride(){
		return $this->id_ride;
	}
	public function getCost_for_driver_wo_tips(){
		return $this->cost_for_driver_wo_tips;
	}
	public function getParking_cost(){
		return $this->parking_cost;
	}
	public function getCollected_from_client(){
		return $this->collected_from_client;
	}
	public function getDriver_tips(){
		return $this->driver_tips;
	}
}