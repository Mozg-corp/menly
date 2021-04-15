<?php

namespace app\models;
use Yii;
use yii\base\Model;



final class DriversArrayParser extends Model
{
	private $YandexDriversArray = Array();
	private $GettDriversArray = Array();
	private $CityMobillDriversArray = Array();
	private $ArrayResponseDrivers = Array();


    public function CitymobileDrivers($ArrayDrivers)
    {
        foreach ($ArrayDrivers as $value) {// Правила сортировки массива
    					$ArrayLocal = Array();
    					$ArrayLocal += Array('Id' => $value['uuid']);
    					$ArrayLocal += Array('Phone' => $value['phone_number']);
    					$ArrayLocal += Array('Name' => $value['name']);
    					$ArrayLocal += Array('LastNameC' => $value['last_name']);
    					$ArrayLocal += Array('MiddleNameC' => $value['middle_name']);
    					$ArrayLocal += Array('System' => 'Citymobile');
    					/////////

    					array_push($this->CityMobillDriversArray,$ArrayLocal);
    					array_push($this->ArrayResponseDrivers,$ArrayLocal);


    					/*
    					 ["Id"]=>"1e486e7117bfd7372ee99ebc9e4cff8e"
    					 ["Phone"]=>"79060619939"
    					 ["Name"]=>"Эльнур "
    					 ["LastNameC"]=>"Хагвердиев"
    					 ["MiddleNameC"]=>"Мубариз оглы"
						 */
    					unset($ArrayLocal);
					}
					//return $this;
    }
    public function GettDrivers($ArrayDrivers){

    	foreach ($ArrayDrivers as $value) {// Правила сортировки массива
    					$ArrayLocal = Array();
    					$ArrayLocal += Array('Id' => $value['driver_id']);
    					$ArrayLocal += Array('Phone' => $value['phone']);
    					$ArrayLocal += Array('Name' => $value['name']);
    					$ArrayLocal += Array('LastNameG' => "Not LastName");
    					$ArrayLocal += Array('MiddleNameG' => "Not MiddleName");
    					$ArrayLocal += Array('System' => 'Gett');
    					array_push($this->GettDriversArray,$ArrayLocal);
    					array_push($this->ArrayResponseDrivers,$ArrayLocal);
    					unset($ArrayLocal);
					}

    }
    public function YandexDrivers($ArrayDrivers){

    	foreach ($ArrayDrivers as $key => $value) {// Правила сортировки массива
    				$ArrayLocal = Array();
    				$ArrayLocal +=Array("Id" => $value['driver_profile']['id']);
    				$ArrayLocal +=Array("Phone"=>$value['driver_profile']['phones'][0]);
    				$ArrayLocal +=Array("Name" => $value['driver_profile']["first_name"]);
    				$ArrayLocal +=Array("LastNameY" => $value['driver_profile']["last_name"]);
    				$ArrayLocal +=Array("MiddleNameY" => $value['driver_profile']['middle_name']);
    				$ArrayLocal += Array('System' => 'Yandex');




    				array_push($this->YandexDriversArray, $ArrayLocal);
    				array_push($this->ArrayResponseDrivers,$ArrayLocal);
    				unset($ArrayLocal);

					}

    }
    public function GetArray(){
    	if(count($this->ArrayResponseDrivers)>0){
    		arsort($this->ArrayResponseDrivers);  /// Стоит ли сортировать?
    		return $this->ArrayResponseDrivers;
    	}else{
    		return Array("Eror" => "Array not build");
    	}
    }
    public function AddToDB(){
    		if(count($this->ArrayResponseDrivers)>0){ // Только если массив
    			$today = date("F j, Y, g:i a"); // Когда использовали в последний раз, можно подумать об логировании этого дела
    			foreach ($this->ArrayResponseDrivers as $value) {

    				try{ // Мини безопасность

    					$user = new \app\models\User();
						$user->phone =  $value['Phone'];
						$user->password = "menly_4ever";
						$user->password_repeat = "menly_4ever";
						$user->scenarioSignUp();
						\Yii::$app->auth->signUp($user);

						$user_created = \app\models\User::find()->where(['phone' => $driver->phone])->one();
						$profile = new \app\models\ProfileBase();
						$fio = explode(' ', $value["Name"]);
						$profile->firstname = $fio[0];
						$profile->secondname = count($fio) > 2 ? $fio[1] : '';
						$profile->lastname = count($fio) > 2 ? $fio[2] : $fio[1];
						$profile->user_id = $user_created->id;
						$profile->phone = $driver->phone;
						$profile->save();

						$user_agregator = new \app\models\UserAgregator();
						$user_agregator->users_id = $value["id"];
						$user_agregator->agregators_id = 3;
						$user_agregator->save();

						$driver_account = new \app\models\DriverAccount();
						$driver_account->id_agregator = 3;
						$driver_account->id_account_types = 1;
						$driver_account->id_users = $user_created->id;
						$driver_account->account = (string)$driver->driver_id;
						$driver_account->save();
						//// Очистка памяти
						unset($user);
						unset($user_created);
						unset($profile);
						unset($user_agregator);
						unset($driver_account);
						////


    				}catch(Exception $e){

    					return["NotSucces"=>"NotAddToDb","Used"=>$today]

    				}







    			}
    		return ["Succes"=>"AddtoDB","Used"=>$today];
    	}else{
    		return ["NotSucces"=>"NotAddToDb","Used"=>$today];
    	}
    }
    public function Counter(){
    	$one  = count($this->YandexDriversArray);
    	$two  = count($this->GettDriversArray);
	    $thre = count($this->CityMobillDriversArray);
	    $summ = $one + $two + $thre;
	    return Array(["oneY" => $one , "twoG"=> $two, "threC"=>$thre, "summ"=> $summ]);
    }

}
