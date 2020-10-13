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
}
