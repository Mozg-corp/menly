<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserBase]].
 *
 * @see UserBase
 */
class UserQuery extends UserBaseQuery
{
   	public function getAgregatorsAccounts(){
		return $this->joinWith('driverAccounts')->select('phone')->all()[24];
	}
}
