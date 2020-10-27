<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gett_orders".
 *
 * @property int $id
 * @property int $id_ride
 * @property string $id_driver
 * @property float|null $cost_for_driver_wo_tips
 * @property float|null $parking_cost
 * @property float|null $collected_from_client
 * @property float|null $driver_tips
 *
 * @property DriverAccount $driver
 */
class GettOrderBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gett_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ride', 'id_driver'], 'required'],
            [['id_ride'], 'integer'],
            [['cost_for_driver_wo_tips', 'parking_cost', 'collected_from_client', 'driver_tips'], 'number'],
            [['id_driver'], 'string', 'max' => 32],
            [['id_ride'], 'unique'],
            [['id_driver'], 'exist', 'skipOnError' => true, 'targetClass' => DriverAccount::className(), 'targetAttribute' => ['id_driver' => 'account']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ride' => 'Id Ride',
            'id_driver' => 'Id Driver',
            'cost_for_driver_wo_tips' => 'Cost For Driver Wo Tips',
            'parking_cost' => 'Parking Cost',
            'collected_from_client' => 'Collected From Client',
            'driver_tips' => 'Driver Tips',
        ];
    }

    /**
     * Gets query for [[Driver]].
     *
     * @return \yii\db\ActiveQuery|DriverAccountQuery
     */
    public function getDriver()
    {
        return $this->hasOne(DriverAccount::className(), ['account' => 'id_driver']);
    }

    /**
     * {@inheritdoc}
     * @return GettOrderBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GettOrderBaseQuery(get_called_class());
    }
}
