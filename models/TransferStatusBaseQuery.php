<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TransferStatusBase]].
 *
 * @see TransferStatusBase
 */
class TransferStatusBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TransferStatusBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TransferStatusBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
