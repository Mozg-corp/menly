<?php

namespace app\models;

use Yii;

/**
 * @OA\Schema(
	required={
		"brand",
		"model",
		"vin",
		"sts",
		"registration",
		"year",
		"color",
		"license",
		"id_users"
	},
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="brand", type="string", example="Mercedes"),
 * @OA\Property(property="model", type="string", example="600"),
 * @OA\Property(property="year", type="string", format="date-time", example="2000"),
 * @OA\Property(property="color", type="string", example="синий"),
 * @OA\Property(property="registration", type="string"),
 * @OA\Property(property="vin", type="string", example="XXXXXXX"),
 * @OA\Property(property="sts", type="string", example="XXXXXXX"),
 * @OA\Property(property="license", type="string", example="XXXXXXXXXX"),
 * @OA\Property(property="id_users", type="integer"),
 ),
 */
class Car extends CarBase
{
	const SCENARIO_UPDATE = 'update car';
	const SCENARIO_CREATE = 'create car';
	public function behaviors(){
	$behaviors = parent::behaviors();
	$behaviors['timestamp'] = [
			'class' => \yii\behaviors\TimestampBehavior::className(),
			'attributes' => [
				\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
			],
			'value' => new \yii\db\Expression('NOW()'),
		];
		return $behaviors;
	}
     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
			[['id_users'], 'unique', 'on' => self::SCENARIO_CREATE],
			[['id_users'], 'exist', 'on' => self::SCENARIO_UPDATE],
			[['year'], 'date', 'format'=>'php:Y'],
			[
				[
					'brand', 
					'model',
					'vin',
					'sts',
					'registration',
					'year',
					'license',
					'color'
				], 'required', 'on' => self::SCENARIO_CREATE,
			],
         ],parent::rules());
    }
	public function fields(){
		return [
			'id',
			'brand',
			'model',
			'year',
			'color',
			'registration',
			'vin',
			'sts',
			'license',
			'id_users'
		];
	}
}
