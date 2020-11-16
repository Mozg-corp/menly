<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Transfer]].
 *
 * @see Transfer
 */
class TransferQuery extends TransferBaseQuery
{
   public function byUserId(int $userId){
	   return $this->where(['id_users' => $userId]);
   }
}
