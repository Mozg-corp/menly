<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account_types".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property DriverAccount[] $driverAccounts
 */
class AccountType extends AccountTypeBase
{
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
            
        ], parent::rules());
    }
	  /**
     * {@inheritdoc}
     * @return AccountTypeBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountTypeQuery(get_called_class());
    }
}
