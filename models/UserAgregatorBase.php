<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_agregators".
 *
 * @property int $users_id
 * @property int $agregators_id
 * @property int $id
 *
 * @property Agregator $agregators
 * @property User $users
 */
class UserAgregatorBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_agregators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'agregators_id'], 'required'],
            [['users_id', 'agregators_id'], 'integer'],
            [['agregators_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agregator::className(), 'targetAttribute' => ['agregators_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'users_id' => 'Users ID',
            'agregators_id' => 'Agregators ID',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[Agregators]].
     *
     * @return \yii\db\ActiveQuery|AgregatorBaseQuery
     */
    public function getAgregators()
    {
        return $this->hasOne(Agregator::className(), ['id' => 'agregators_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UserBaseQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'users_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserAgregatorBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAgregatorBaseQuery(get_called_class());
    }
}
