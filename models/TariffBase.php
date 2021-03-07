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
class TariffBase extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariffs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['subscription', 'rate'], 'number'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
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
            'subscription' => 'Subscription',
            'rate' => 'Rate',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery|SubscriptionQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['id_tariffs' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TariffBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TariffBaseQuery(get_called_class());
    }
}
