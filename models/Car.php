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
     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
		
         ],parent::rules());
    }
}
