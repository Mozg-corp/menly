<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AccountType]].
 *
 * @see AccountType
 */
class AccountTypeQuery extends AccountTypeBaseQuery
{
   public function byName(string $typeName){
	   return $this->where(['name' => $typeName]);
   }
}
