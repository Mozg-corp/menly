<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string $firstname
 * @property string|null $secondname
 * @property string $lastname
 * @property string|null $phone
 * @property string|null $birthdate
 * @property string|null $passport_series
 * @property string|null $passport_number
 * @property string|null $passport_giver
 * @property string|null $passport_date
 * @property string|null $registration_address
 * @property string|null $license_series
 * @property string|null $license_number
 * @property string|null $license_date
 * @property string|null $license_expire
 */
class Profile extends ProfileBase
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
