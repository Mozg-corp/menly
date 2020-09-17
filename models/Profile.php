<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\BaseFileHelper;
use Ramsey\Uuid\Uuid;

/**
 * @OA\Component((required={'firstname', 
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
					}),
 * @OA\Schema(
 * @OA\Property(property="firstname", type="string"),
 * @OA\Property(property="lastname", type="string"),
 * @OA\Property(property="phone", type="string"),
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
			'phone',
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
