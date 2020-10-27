<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GettOrder]].
 *
 * @see GettOrder
 */
class GettOrderQuery extends GettOrderBaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GettOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GettOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
	public function byRide($ride){
		return $this->where(['id_ride' => $ride->id_ride]);//если $ride это модель Ride, то нужно взять ->id_ride
	}
}
