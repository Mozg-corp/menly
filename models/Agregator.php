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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
		
         ],parent::rules());
    }
}
