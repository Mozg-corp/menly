<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AgregatorBase]].
 *
 * @see AgregatorBase
 */
class AgregatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AgregatorBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AgregatorBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
