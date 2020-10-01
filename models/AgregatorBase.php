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
 *
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
            [['apiv1', 'apiv2', 'refresh_token'], 'string', 'max' => 255],
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
        ];
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
