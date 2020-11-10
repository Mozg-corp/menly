<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DriverAccount]].
 *
 * @see DriverAccount
 */
class DriverAccountQuery extends DriverAccountBaseQuery
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
	public function byAccount($account){
		return $this->where(['account' => $account]);
	}
	public function agregatorsAccountsArray(int $id_user):\yii\db\ActiveQuery{
		return $this->where(['id_users' => $id_user])
					->select('name, account, id_agregator')
					->joinWith('agregator')
					->asArray();
	}
	public function agregatorAccoutByName(int $id_user, string agregatorName): \yii\db\ActiveQuery{
		return $this->where(['id_users' => $id_user])
					->select('name, account, id_agregator')
					->joinWith('agregator')
					->andWhere(['name' => $agregatorName])
					->asArray();
	}
}
