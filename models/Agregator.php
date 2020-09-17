<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agregators".
 *
 * @property int $id
 * @property string $name
 * @property string|null $apiv1
 * @property string|null $apiv2
 *
 * @property UsersAgregators[] $usersAgregators
 */
class Agregator extends AgregatorBase
{
	const SCENARIO_UPDATE = 'update agregator';
	const SCENARIO_CREATE = 'create agregator';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
			[['name'], 'unique', 'on' => self::SCENARIO_CREATE],
			[['name'], 'required', 'on' => self::SCENARIO_CREATE],
			[['name'], 'exist', 'on' => self::SCENARIO_UPDATE],
         ],parent::rules());
    }
}
