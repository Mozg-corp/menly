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
            [['phone'], 'string', 'max' => 20],
            [['password_hash'], 'string', 'max' => 300],
            [['token', 'auth_key'], 'string', 'max' => 150],
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
        ];
    }
}
