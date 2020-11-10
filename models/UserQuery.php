<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserBase]].
 *
 * @see UserBase
 */
class UserQuery extends UserBaseQuery
{
   	public function byPhone(string $phone){
		return $this->where(['phone' => $phone]);
	}
}
