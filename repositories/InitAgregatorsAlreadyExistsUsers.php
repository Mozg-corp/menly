<?php namespace app\repositories;
class InitAgregatorsAlreadyExistsUsers{
	public $users = [];
	public function saveUsersToDb(){
		forEach($this->users as $phone => $userData){
			$foundUser = \app\models\User::find()->byPhone($phone)->one();
			if(!$foundUser){
				$this->createUser($phone);
			}
			//*
			// print_r($userData);die;
			$user_created = \app\models\User::find()->byPhone($phone)->one();
			if($user_created){
				$this->createProfile($phone, $userData, $user_created);
				$foundProfile = \app\models\Profile::find()->byUserId($user_created->id)->one();
				///*
				if($foundProfile){
					$this->saveDriversData($phone, $userData, $user_created);
				}
			}
			//*/
		}
	}
	private function saveDriversData(string $phone, array $userData, \app\models\User $user){
		forEach($userData['agregators'] as $agregatorName => $driverAccount){
			$agregator = \app\models\Agregator::find()->getAgregatorByName($agregatorName);
			if($agregator){
				$this->createUserAgregatorRelation($user, $agregator);
				$this->createDriverAccount($user, $agregator, $driverAccount);
			}
		}
	}
	private function createDriverAccount(\app\models\User $user, \app\models\Agregator $agregator, string $driverAccount){
		if($agregator && $user && $driverAccount){
			$accountType = \app\models\AccountType::find()->byName('driver')->one();
			$driver_account = new \app\models\DriverAccount();
			$driver_account->account = $driverAccount;
			$driver_account->id_account_types = $accountType->id;
			$driver_account->id_users = $user->id;
			$driver_account->id_agregator = $agregator->id;
			print_r($driver_account);
			$driver_account->save();
		}
	}
	private function createUserAgregatorRelation(\app\models\User $user, \app\models\Agregator $agregator){
		if($agregator && $user){
			$user_agregator = new \app\models\UserAgregator();
			$user_agregator->users_id = $user->id;
			$user_agregator->agregators_id = $agregator->id;
			print_r($user_agregator);
			$user_agregator->save();
		}
	}
	private function createProfile(string $phone, array $userData, \app\models\User $user){
		$foundProfile = \app\models\Profile::find()->byUserId($user->id)->one();
		if($user && !$foundProfile){
			$profile = new \app\models\ProfileBase();
			$profile->firstname = $userData['firstname'];
			$profile->secondname = $userData['secondname'];
			$profile->lastname = $userData['lastname'];
			$profile->phone = $phone;
			$profile->link('user', $user);
			$profile->save();
		}
	}
	private function createUser(string $phone){
		// $foundUser = \app\models\User::find()->byPhone($phone)->one();
		$user = new \app\models\User();
		$user->phone = $phone;
		$user->password = "menly_4ever";
		$user->password_repeat = "menly_4ever";
		$user->scenarioSignUp();
		\Yii::$app->auth->signUp($user);
	}
	public function readJson(array $paths){
		$this->readCityUsers($paths['Ситимобиль']);
		$this->readYaUsers($paths['Яндекс']);
		//$this->readGettUsers($paths['Gett']);
	}
	public function readGettUsers(string $path){
		$drivers = $this->readFromFile($path);
		forEach($drivers->data as $driver){

			$phone = $driver->phone;
			$fio = explode(' ', $driver->name);
			if(array_key_exists($phone, $this->users)){
				$this->users[$phone]['agregators']['Gett'] = (string)$driver->driver_id;
			}else{
				$subArray = [];
				$subArray['firstname'] = count($fio) > 2 ? $fio[1] : '';
				$subArray['secondname'] = count($fio) > 2 ? $fio[2] : $fio[1];
				$subArray['lastname'] = $fio[0];
				$subArray['agregators'] = ['Gett' => (string)$driver->driver_id];
				$this->users[$phone] = $subArray;
			}			
		}
	}
	public function readYaUsers(string $path){
		$drivers = $this->readFromFile($path);
		forEach($drivers->driver_profiles as $driver){
			$phone = substr($driver->driver_profile->phones[0], 1);
			if(array_key_exists($phone, $this->users)){
				$this->users[$phone]['agregators']['Яндекс'] = $driver->accounts[0]->id;
			}else{
				$subArray = [];
				$subArray['firstname'] =  $driver->driver_profile->first_name;
				$subArray['secondname'] =  $driver->driver_profile->middle_name?? '';
				$subArray['lastname'] =  $driver->driver_profile->last_name;
				$subArray['agregators'] = ['Яндекс' => $driver->accounts[0]->id];
				$this->users[$phone] = $subArray;
			}
		}
	}
	public function readCityUsers(string $path){
		$drivers = $this->readFromFile($path);
		forEach($drivers->drivers as $driver){
			$phone = $driver->phone_number;
			if(array_key_exists($phone, $this->users)){
				$this->users[$phone]['agregators']['Ситимобиль'] = $driver->uuid;
			}else{
				$subArray = [];
				$subArray['firstname'] = $driver->name;
				$subArray['secondname'] = $driver->middle_name;
				$subArray['lastname'] = $driver->last_name;
				$subArray['agregators'] = ['Ситимобиль' => $driver->uuid];
				$this->users[$phone] = $subArray;
			}
		}
	}
	private function readFromFile(string $path){
		$raw_drivers = file_get_contents($path);
		$drivers = json_decode($raw_drivers);
		return $drivers;
	}
}