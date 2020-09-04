<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\BaseFileHelper;
use Ramsey\Uuid\Uuid;

/**
 * @OA\Component((required={"firstname", "lastname"}),
 * @OA\Schema(
 * @OA\Property(property="firstname", type="string"),
 * @OA\Property(property="lastname", type="string"),
 * @OA\Property(property="phone", type="string"),
 )
 */
class Profile extends ProfileBase
{
	public $fotos = [
		'file_foto_selfie',
		'file_foto_passport_fotopage',
		'file_foto_passport_registrationpage',
		'file_foto_license_frontview',
		'file_foto_license_backview'
	];
	public $forms = [
		'foto_selfie',
		'foto_passport_fotopage',
		'foto_passport_registrationpage',
		'foto_license_frontview',
		'foto_license_backview'
	];
    /**
     * @var UploadedFile file attribute
     */
    public $file_foto_selfie;
    /**
     * @var UploadedFile file attribute
     */
	public $file_foto_passport_fotopage;
    /**
     * @var UploadedFile file attribute
     */
	public $file_foto_passport_registrationpage;
    /**
     * @var UploadedFile file attribute
     */
	public $file_foto_license_frontview;
    /**
     * @var UploadedFile file attribute
     */
	public $file_foto_license_backview;
	
	public $yandex;
	public $gett;
	public $citymobile;
	public $uber;
	
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
			[['firstname','lastname','secondname', 'license_series', 'license_number', ], 'trim'],
			[['license_date', 'license_expire', 'birthdate', 'passport_date'], 'date', 'format'=>'php:Y-m-d']
         ],parent::rules());
    }
	private function loadFiles():void{
		for($i=0; $i<count($this->fotos); $i++){
			try{
				if(property_exists($this, $this->fotos[$i])){
					$file = UploadedFile::getInstance($this, $this->forms[$i]);
					$this->{$this->fotos[$i]} = $file ? $file : null;
				}
			}catch(Exeption $e){
				\Yii::debug($e);
				continue;
			}
		}
	}
	public function fill($form){
		$this->loadFiles();
		$uuid = $this->uuid ? $this->uuid : Uuid::uuid4()->toString();
		$directory= 'profiles/' . $uuid;
		FileHelper::createDirectory($directory);
		for($i=0; $i<count($this->fotos); $i++){
			try{
				if($this->{$this->fotos[$i]}){
					$filename = $this->{$this->fotos[$i]}->baseName . '.' . $this->{$this->fotos[$i]}->extension;
					$path = $directory . '/'. $filename;
					if($this->{$this->forms[$i]}){
						file_exists($directory . '/' . $this->{$this->forms[$i]})
						? BaseFileHelper::unlink($directory . '/' . $this->{$this->forms[$i]})
						: null;
					}
					$this->{$this->fotos[$i]}->saveAs($path);
					$this->{$this->forms[$i]} = $filename;
				}
			}catch(Exeption $e){
				continue;
			}
		}
			$this->uuid = $uuid;
			$this->firstname = $form->firstname;
			$this->secondname = $form->secondname;
			$this->lastname = $form->lastname;
			$this->phone = $form->phone;
			$this->birthdate = $form->birthdate;
			$this->passport_series = $form->passport_series;
			$this->passport_number = $form->passport_number;
			$this->passport_giver = $form->passport_giver;
			$this->passport_date = $form->passport_date;
			$this->registration_address = $form->registration_address;
			$this->license_series = $form->license_series;
			$this->license_date = $form->license_date;
			$this->license_expire = $form->license_expire;
	}
}
