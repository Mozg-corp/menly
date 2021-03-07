<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TariffBase]].
 *
 * @see TariffBase
 */
class TariffBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TariffBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TariffBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
