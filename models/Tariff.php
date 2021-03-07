<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tariffs".
 *
 * @property int $id
 * @property string $name
 * @property float|null $subscription
 * @property float|null $rate
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Subscription[] $subscriptions
 */
class Tariff extends TariffBase
{
    // const SCENARIO_UPDATE = 'update tariff';
    const SCENARIO_CREATE = 'create tariff';

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
            'name' => 'Name',
            'subscription' => 'Subscription',
            'rate' => 'Rate',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function find()
    {
        return new TariffQuery(get_called_class());
    }
}
