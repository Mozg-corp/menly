<?php

namespace app\models;

use Yii;

class TransferStatus extends TransferStatusBase
{
	/**
     * {@inheritdoc}
     * @return TransferStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransferStatusQuery(get_called_class());
    }
}
