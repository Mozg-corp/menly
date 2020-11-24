<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agregators".
 *
 * @property int $id
 * @property string $name
 * @property string|null $apiv1
 * @property string|null $apiv2
 * @property string|null $token
 * @property int|null $expire
 * @property string|null $refresh_token
 * @property string|null $logo
 *
 * @property DriverAccount[] $driverAccounts
 * @property Transfer[] $transfers
 * @property UsersAgregator[] $usersAgregators
 */
class AgregatorBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['token'], 'string'],
            [['expire'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['apiv1', 'apiv2', 'refresh_token', 'logo'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'apiv1' => 'Apiv1',
            'apiv2' => 'Apiv2',
            'token' => 'Token',
            'expire' => 'Expire',
            'refresh_token' => 'Refresh Token',
            'logo' => 'Logo',
        ];
    }

    /**
     * Gets query for [[DriverAccounts]].
     *
     * @return \yii\db\ActiveQuery|DriverAccountQuery
     */
    public function getDriverAccounts()
    {
        return $this->hasMany(DriverAccount::className(), ['id_agregator' => 'id']);
    }

    /**
     * Gets query for [[Transfers]].
     *
     * @return \yii\db\ActiveQuery|TransferQuery
     */
    public function getTransfers()
    {
        return $this->hasMany(Transfer::className(), ['id_agregators' => 'id']);
    }

    /**
     * Gets query for [[UsersAgregators]].
     *
     * @return \yii\db\ActiveQuery|UsersAgregatorQuery
     */
    public function getUsersAgregators()
    {
        return $this->hasMany(UsersAgregator::className(), ['agregators_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AgregatorBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgregatorBaseQuery(get_called_class());
    }
}
