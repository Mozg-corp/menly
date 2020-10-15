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
class DriverAccount extends DriverAccountBase
{
    /**
     * {@inheritdoc}
     * @return DriverAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DriverAccountQuery(get_called_class());
    }
}
