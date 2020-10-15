<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gett_balances".
 *
 * @property int $id
 * @property int $id_driver
 * @property float|null $balance
 * @property float|null $tips
 * @property float|null $parking_cost
 *
 * @property DriverAccount $driver
 */
class GettBalance extends GettBalanceBase
{
    /**
     * {@inheritdoc}
     * @return GettBalanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GettBalanceQuery(get_called_class());
    }
	public function fillFromRide($ride){
		
		$this->id_driver = $ride->id_driver;
		$this->balance = $ride->calculateTax();
		$this->tips = $ride->tips;
		$this->parking_cost = $ride->parkingCost;
	}
	public function accumulateRide($ride){
		$this->balance += $ride->calculateTax();
		$this->tips += $ride->tips;
		$this->parking_cost += $ride->parkingCost;
	}
}
