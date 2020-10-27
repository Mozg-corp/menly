<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GettOrderBase]].
 *
 * @see GettOrderBase
 */
class GettOrderBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GettOrderBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GettOrderBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
