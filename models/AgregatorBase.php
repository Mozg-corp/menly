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
 *
 * @property UsersAgregators[] $usersAgregators
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
            [['name'], 'string', 'max' => 50],
            [['apiv1', 'apiv2'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[UsersAgregators]].
     *
     * @return \yii\db\ActiveQuery|UsersAgregatorsQuery
     */
    public function getUsersAgregators()
    {
        return $this->hasMany(UsersAgregators::className(), ['agregators_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AgregatorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgregatorQuery(get_called_class());
    }
}
