<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DriverAccountBase]].
 *
 * @see DriverAccountBase
 */
class DriverAccountBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DriverAccountBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DriverAccountBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
