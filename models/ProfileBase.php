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
 * @property string|null $foto_selfie
 * @property string|null $foto_passport_fotopage
 * @property string|null $foto_passport_registrationpage
 * @property string|null $foto_license_frontview
 * @property string|null $foto_license_backview
 * @property string|null $uuid
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property int $user_id
 */
class ProfileBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'user_id'], 'required'],
            [['birthdate', 'passport_date', 'license_date', 'license_expire', 'createdAt', 'updatedAt'], 'safe'],
            [['user_id'], 'integer'],
            [['firstname', 'secondname', 'lastname'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['passport_series', 'license_series'], 'string', 'max' => 4],
            [['passport_number', 'license_number'], 'string', 'max' => 6],
            [['passport_giver', 'registration_address', 'foto_selfie', 'foto_passport_fotopage', 'foto_passport_registrationpage', 'foto_license_frontview', 'foto_license_backview'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'secondname' => 'Secondname',
            'lastname' => 'Lastname',
            'phone' => 'Phone',
            'birthdate' => 'Birthdate',
            'passport_series' => 'Passport Series',
            'passport_number' => 'Passport Number',
            'passport_giver' => 'Passport Giver',
            'passport_date' => 'Passport Date',
            'registration_address' => 'Registration Address',
            'license_series' => 'License Series',
            'license_number' => 'License Number',
            'license_date' => 'License Date',
            'license_expire' => 'License Expire',
            'foto_selfie' => 'Foto Selfie',
            'foto_passport_fotopage' => 'Foto Passport Fotopage',
            'foto_passport_registrationpage' => 'Foto Passport Registrationpage',
            'foto_license_frontview' => 'Foto License Frontview',
            'foto_license_backview' => 'Foto License Backview',
            'uuid' => 'Uuid',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
