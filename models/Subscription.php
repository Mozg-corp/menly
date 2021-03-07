<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscriptions".
 *
 * @property int $id
 * @property int $id_users
 * @property int $id_tariffs
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Tariff $tariffs
 * @property User $users
 */
class Subscription extends SubscriptionBase
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([

        ], parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_users' => 'Id Users',
            'id_tariffs' => 'Id Tariffs',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscriptionQuery(get_called_class());
    }
}
