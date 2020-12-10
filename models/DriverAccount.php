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
	const SCENARIO_CREATE = 'create driver account';
	const SCENARIO_UPDATE = 'update driver account';
	public function fields(){
		return [
			'account',
			'agregator'
		];
	}
	public function scenarios(){
		return [
			self::SCENARIO_UPDATE => ['account'],
		    self::SCENARIO_CREATE => ['account', 'id_agregator', 'id_users', 'id_account_types'],
		];
	}
    public static function find()
    {
        return new DriverAccountQuery(get_called_class());
    }
}
