<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserAgregatorBase]].
 *
 * @see UserAgregatorBase
 */
class UserAgregatorBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserAgregatorBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserAgregatorBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
