<?php

namespace app\models;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\BaseFileHelper;
use Ramsey\Uuid\Uuid;


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
	
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
		
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
		if($this->validate()){
			$uuid = $this->uuid ? $this->uuid : Uuid::uuid4()->toString();
			$directory= 'profiles/' . $uuid;
			FileHelper::createDirectory($directory);
			for($i=0; $i<count($this->fotos); $i++){
				try{
					if($this->{$this->fotos[$i]}){
						$filename = $this->{$this->fotos[$i]}->baseName . '.' . $this->{$this->fotos[$i]}->extension;
						$path = $directory . '/'. $filename;
						if($this->{$this->forms[$i]}){
							BaseFileHelper::unlink($directory . '/' . $this->{$this->forms[$i]});
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
}
