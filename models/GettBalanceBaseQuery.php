<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GettBalanceBase]].
 *
 * @see GettBalanceBase
 */
class GettBalanceBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GettBalanceBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GettBalanceBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
