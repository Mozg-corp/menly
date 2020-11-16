<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfers".
 *
 * @property int $id
 * @property int $id_users
 * @property int $id_agregators
 * @property int $id_transfer_statuses
 * @property string|null $transfer
 * @property string|null $description
 * @property string|null $agregator_transfer_id
 * @property string|null $bank_transfer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Agregator $agregators
 * @property TransferStatus $transferStatuses
 * @property User $users
 */
class TransferBase extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_users', 'id_agregators'], 'required'],
            [['id_users', 'id_agregators', 'id_transfer_statuses'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['transfer', 'agregator_transfer_id'], 'string', 'max' => 50],
            [['description', 'bank_transfer_id'], 'string', 'max' => 255],
            [['id_agregators'], 'exist', 'skipOnError' => true, 'targetClass' => Agregator::className(), 'targetAttribute' => ['id_agregators' => 'id']],
            [['id_transfer_statuses'], 'exist', 'skipOnError' => true, 'targetClass' => TransferStatus::className(), 'targetAttribute' => ['id_transfer_statuses' => 'id']],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_users' => 'Id Users',
            'id_agregators' => 'Id Agregators',
            'id_transfer_statuses' => 'Id Transfer Statuses',
            'transfer' => 'Transfer',
            'description' => 'Description',
            'agregator_transfer_id' => 'Agregator Transfer ID',
            'bank_transfer_id' => 'Bank Transfer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Agregators]].
     *
     * @return \yii\db\ActiveQuery|AgregatorQuery
     */
    public function getAgregators()
    {
        return $this->hasOne(Agregator::className(), ['id' => 'id_agregators']);
    }

    /**
     * Gets query for [[TransferStatuses]].
     *
     * @return \yii\db\ActiveQuery|TransferStatusBaseQuery
     */
    public function getTransferStatuses()
    {
        return $this->hasOne(TransferStatus::className(), ['id' => 'id_transfer_statuses']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }

    /**
     * {@inheritdoc}
     * @return TransferBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransferBaseQuery(get_called_class());
    }
}
