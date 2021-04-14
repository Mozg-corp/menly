<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $phone
 * @property string $password_hash
 * @property string|null $token
 * @property string|null $auth_key
 * @property string|null $create_at
 * @property string|null $updated_at
 * @property int|null $status
 *
 * @property Car[] $cars
 * @property DriverAccount[] $driverAccounts
 * @property Profile[] $profiles
 * @property Subscription[] $subscriptions
 * @property Transfer[] $transfers
 * @property UsersAgregator[] $usersAgregators
 */
class UserBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'password_hash'], 'required'],
            [['create_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['password_hash'], 'string', 'max' => 300],
            [['token', 'auth_key'], 'string', 'max' => 150],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'password_hash' => 'Password Hash',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Cars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['id_users' => 'id']);
    }

    /**
     * Gets query for [[DriverAccounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriverAccounts()
    {
        return $this->hasMany(DriverAccount::className(), ['id_users' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['id_users' => 'id']);
    }

    /**
     * Gets query for [[Transfers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransfers()
    {
        return $this->hasMany(Transfer::className(), ['id_users' => 'id']);
    }

    /**
     * Gets query for [[UsersAgregators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersAgregators()
    {
        return $this->hasMany(UsersAgregator::className(), ['users_id' => 'id']);
    }

}
