<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubscriptionBase]].
 *
 * @see SubscriptionBase
 */
class SubscriptionBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SubscriptionBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SubscriptionBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
