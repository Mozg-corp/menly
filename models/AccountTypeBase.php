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
class AccountTypeBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[DriverAccounts]].
     *
     * @return \yii\db\ActiveQuery|DriverAccountQuery
     */
    public function getDriverAccounts()
    {
        return $this->hasMany(DriverAccount::className(), ['id_account_types' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AccountTypeBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountTypeBaseQuery(get_called_class());
    }
}
