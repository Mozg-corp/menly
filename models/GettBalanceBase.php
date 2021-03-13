<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gett_balances".
 *
 * @property int $id
 * @property string $id_driver
 * @property float|null $balance
 * @property float|null $tips
 * @property float|null $parking_cost
 * @property string|null $updated_at
 * @property string|null $created_at
 * @property float|null $debit
 *
 * @property DriverAccount $driver
 */
class GettBalanceBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gett_balances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_driver'], 'required'],
            [['balance', 'tips', 'parking_cost', 'debit'], 'number'],
            [['updated_at', 'created_at'], 'safe'],
            [['id_driver'], 'string', 'max' => 32],
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
            'id_driver' => 'Id Driver',
            'balance' => 'Balance',
            'tips' => 'Tips',
            'parking_cost' => 'Parking Cost',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'debit' => 'Debit',
        ];
    }

    /**
     * Gets query for [[Driver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(DriverAccount::className(), ['account' => 'id_driver']);
    }
}
