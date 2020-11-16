<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TransferStatus]].
 *
 * @see TransferStatus
 */
class TransferStatusQuery extends TransferStatusBaseQuery
{
  public function byStatus(string $status){
	  return $this->where(['status' => $status]);
  }
}
