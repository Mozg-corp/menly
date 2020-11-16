<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer_statuses".
 *
 * @property int $id
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TransferStatusBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfer_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TransferStatusBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransferStatusBaseQuery(get_called_class());
    }
}
