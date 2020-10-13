<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver_accounts".
 *
 * @property int $id
 * @property int $id_agregator
 * @property int $id_account_types
 *
 * @property AccountType $accountTypes
 * @property Agregator $agregator
 */
class DriverAccount extends DriverAccountBase
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
