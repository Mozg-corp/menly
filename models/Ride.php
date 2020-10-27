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
	public function exist(){
		$found = \app\models\GettOrder::find()->byRide($this)->one();
		return $found ? true : false;
	}
	public function balanceExist(){
		$found = \app\models\GettBalance::find()->byDriver($this)->one();
		return $found ? true : false;
	}
	public function userExist(){
		$gett = \app\models\Agregator::find()->getAgregatorByName('Gett');
		$user = \app\models\User::find()
							->joinWith('driverAccounts')
							->where(['account' => $this->id_driver])
							->andWhere(['id_agregator' => $gett->id])
							->one();
		return $user ? true : false;
	}
	public function getOrder(){
		return \app\models\GettOrder::find()->byRide($this)->one();
	}
	public function getBalance(){
		$tax = $this->calculateTax();
		$tips = $this->tips;
		$parking_cost = $this->parkingCost;
		
		return $tax + $tips - $parking_cost;
	}
	public function balanceChanged(){
		$order = $this->order;
		$order_balance = $order->balance;
		$ride_balance = $this->balance;
		$diff = $order_balance - $ride_balance ;
		return abs($diff) >= 0.01;
	}
	public function updateOrder(){
		$order = $this->order;
		$order->fillFromRide($this);
		$order->save();
	}
	public function saveOrder(){
		$order = new \app\models\GettOrder();
		$order->fillFromRide($this);
		$order->save();
	}
	public function saveBalance(){
		$balance = null;
		if($this->balanceExist()){
			$balance = \app\models\GettBalance::find()->byDriver($this)->one();
			$balance->accumulateRide($this);
		}else{
			$balance = new \app\models\GettBalance();
			$balance->fillFromRide($this);
		}
		$balance->save();
	}
	public function updateBalance(){
		$balance = \app\models\GettBalance::find()->byDriver($this)->one();
		$order = $this->order;
		
		$tipsDiff = $this->driver_tips - $order->tips;
		$parkingCostDiff = $this->parkingCost - $order->parkingCost;
		$taxDiff = $this->calculateTax() - $order->calculateTax();
		
		$balance->balance += abs($taxDiff) >= 0.01 ? $taxDiff : 0;
		$balance->tips += abs($tipsDiff) >= 0.01 ? $tipsDiff : 0;
		$balance->parking_cost += abs($parkingCostDiff) >= 0.01 ? $parkingCostDiff : 0;
		
		$balance->save();
	}
	public function updateOrderAndBalance(){
		//!!! здесь очень важно, чтобы обновлялся сперва баланс, 
		//а потом уже заказ (поезка)
		$this->updateBalance(); 
		$this->updateOrder();
	}
}