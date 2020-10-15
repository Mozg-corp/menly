<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver_accounts".
 *
 * @property int $id
 * @property int $id_agregator
 * @property int $id_account_types
 * @property int $id_users
 *
 * @property AccountType $accountTypes
 * @property Agregator $agregator
 * @property User $users
 */
class DriverAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driver_accounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_agregator', 'id_account_types', 'id_users'], 'required'],
            [['id_agregator', 'id_account_types', 'id_users'], 'integer'],
            [['id_account_types'], 'exist', 'skipOnError' => true, 'targetClass' => AccountType::className(), 'targetAttribute' => ['id_account_types' => 'id']],
            [['id_agregator'], 'exist', 'skipOnError' => true, 'targetClass' => Agregator::className(), 'targetAttribute' => ['id_agregator' => 'id']],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_agregator' => 'Id Agregator',
            'id_account_types' => 'Id Account Types',
            'id_users' => 'Id Users',
        ];
    }

    /**
     * Gets query for [[AccountTypes]].
     *
     * @return \yii\db\ActiveQuery|AccountTypeBaseQuery
     */
    public function getAccountTypes()
    {
        return $this->hasOne(AccountType::className(), ['id' => 'id_account_types']);
    }

    /**
     * Gets query for [[Agregator]].
     *
     * @return \yii\db\ActiveQuery|AgregatorQuery
     */
    public function getAgregator()
    {
        return $this->hasOne(Agregator::className(), ['id' => 'id_agregator']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UserBaseQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }

    /**
     * {@inheritdoc}
     * @return DriverAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DriverAccountQuery(get_called_class());
    }
}
