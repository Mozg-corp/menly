<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gett_orders".
 *
 * @property int $id
 * @property int $id_ride
 * @property int $id_driver
 * @property float|null $cost_for_driver_wo_tips
 * @property float|null $parking_cost
 * @property float|null $collected_from_client
 * @property float|null $driver_tips
 *
 * @property DriverAccount $driver
 */
class GettOrder extends GettOrderBase
{
    /**
     * {@inheritdoc}
     * @return GettOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GettOrderQuery(get_called_class());
    }
	public function fillFromRide($ride){
		$this->id_ride = $ride->id_ride;
		$this->id_driver = $ride->id_driver;
		$this->cost_for_driver_wo_tips = $ride->cost_for_driver_wo_tips;
		$this->parking_cost = $ride->parking_cost;
		$this->collected_from_client = $ride->collected_from_client;
		$this->driver_tips = $ride->driver_tips;
	}
}
