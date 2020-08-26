<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string|null $brand
 * @property string|null $model
 * @property string|null $year
 * @property string|null $color
 * @property string|null $registration
 * @property string|null $vin
 * @property string|null $sts
 * @property string|null $license
 * @property int $id_users
 *
 * @property Users $users
 */
class CarBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_users'], 'required'],
            [['id_users'], 'integer'],
            [['brand', 'model', 'color'], 'string', 'max' => 50],
            [['year'], 'string', 'max' => 4],
            [['registration'], 'string', 'max' => 9],
            [['vin'], 'string', 'max' => 17],
            [['sts', 'license'], 'string', 'max' => 10],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Brand',
            'model' => 'Model',
            'year' => 'Year',
            'color' => 'Color',
            'registration' => 'Registration',
            'vin' => 'Vin',
            'sts' => 'Sts',
            'license' => 'License',
            'id_users' => 'Id Users',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }

    /**
     * {@inheritdoc}
     * @return CarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarQuery(get_called_class());
    }
}
