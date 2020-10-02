<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\BaseFileHelper;
use Ramsey\Uuid\Uuid;

/**
 * @OA\Component(),
 * @OA\Schema(
 required={"firstname", 
					"secondname",
					"lastname",
					"birthdate",
					"phone",
					"passport_series",
					"passport_number", 
					"passport_giver", 
					"passport_date", 
					"registration_address", 
					"license_series",
					"license_number",
					"license_date",
					"license_expire",
					"user_id"
					},
 * @OA\Property(property="firstname", type="string", example="Иван"),
 * @OA\Property(property="secondname", type="string", example="Иванович"),
 * @OA\Property(property="lastname", type="string", example="Иванов"),
 * @OA\Property(property="birthdate", type="string", format="date-time", example="21.20.2001"),
 * @OA\Property(property="phone", type="string", example="79991234567"),
	@OA\Property(property="passport_series", type="string", example="XXXX"),
	@OA\Property(property="passport_number", type="string", example="XXXXXX"),
	@OA\Property(property="passport_giver", type="string"),
	@OA\Property(property="passport_date", type="string", format="date-time", example="21.01.2008"),
	@OA\Property(property="registration_address", type="string"),
	 @OA\Property(property="license_series", type="string", example="XXXX"),
	 @OA\Property(property="license_number", type="string", example="XXXXXX"),
	 @OA\Property(property="license_date", type="string", format="date-time", example="21.01.2015"),
	 @OA\Property(property="license_expire", type="string", format="date-time", example="21.05.2025"),
	 @OA\Property(property="user_id", type="integer")

	),

 )
 */
class Profile extends ProfileBase
{
	const SCENARIO_CREATE = 'create profile';
	const SCENARIO_UPDATE = 'update profile';
	
	public function beforeValidate(){
		$dates = [
			'license_date',
			'license_expire',
			'birthdate',
			'passport_date'
		];
		foreach($dates as $date){
			$newDate= \Datetime::CreateFromFormat('d.m.Y',$this->{$date});
			if($newDate){
				$this->{$date} = $newDate->format('Y-m-d');
			}
			
		}
		return parent::beforeValidate();
	}
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
			[
				[
					'firstname', 
					'secondname',
					'lastname',
					'birthdate',
					'phone',
					'passport_series',
					'passport_number', 
					'passport_giver', 
					'passport_date', 
					'registration_address', 
					'license_series',
					'license_number',
					'license_date',
					'license_expire'
				], 'required', 'on' => self::SCENARIO_CREATE
			],
			[['firstname','lastname','secondname', 'license_series', 'license_number', ], 'trim'],
			[['license_date', 'license_expire', 'birthdate', 'passport_date'], 'date', 'format'=>'php:Y-m-d'],
			[['user_id'], 'unique', 'on' => self::SCENARIO_CREATE],
			[['user_id'], 'exist', 'on' => self::SCENARIO_UPDATE]
         ],parent::rules());
    }
	public function fields(){
		return [
			'id',
			'firstname',
			'lastname',
			'fio' => function(){
				return $this->lastname . ' ' . $this->firstname . ' ' . $this->secondname;
			},
			'birthdate',
			'phone'
		];
	}
	public function extraFields(){
		return [
			'passport' => function(){
				return [
					'series' => $this->passport_series,
					'number' => $this->passport_number,
					'giver' => $this->passport_giver,
					'date' => $this->passport_date,
					'registration' => $this->registration_address
				];
			},
			'license' => function(){
				return [
					'series' => $this->license_series,
					'number' => $this->license_number,
					'date' => $this->license_date,
					'expire' => $this->license_expire
				];
			}
		];
	}
}
