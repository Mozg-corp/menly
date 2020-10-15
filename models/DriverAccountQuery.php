<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DriverAccount]].
 *
 * @see DriverAccount
 */
class DriverAccountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DriverAccount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DriverAccount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
