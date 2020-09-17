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
 * @property Profile[] $profiles
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
     * {@inheritdoc}
     * @return UserBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserBaseQuery(get_called_class());
    }
}
