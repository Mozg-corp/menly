<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProfileBase]].
 *
 * @see ProfileBase
 */
class ProfileQuery extends ProfileBaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
