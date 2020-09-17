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
 * @property User $user
 */
class Car extends CarBase
{
	const SCENARIO_UPDATE = 'update car';
	const SCENARIO_CREATE = 'create car';
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
					'color'
				], 'required', 'on' => self::SCENARIO_CREATE,
			],
         ],parent::rules());
    }
}
