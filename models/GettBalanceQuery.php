<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GettBalanceBase]].
 *
 * @see GettBalance
 */
class GettBalanceQuery extends GettBalanceBaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GettBalance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GettBalance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
	public function byDriver($ride){
		return $this->where(['id_driver' => $ride->id_driver]);
	}
	public function byDriverId($id_driver){
		return $this->where(['id_driver' => $id_driver]);
	}
}
