<?php namespace app\services;

$auth = file_exists('@app/config/citimobile_auth_local.php')
			? (require '@app/config/citimobile_auth_local.php')
			: [];

use app\interfaces\RegisterInterface;

class CitymobileProfileRegister implements RegisterInterface{
	private $profile;
	private $auth;
	private $client;
	public function __construct(\yii\db\ActiveRecord $profile, $auth, $client){
		$this->profile = $profile;
		$this->auth = $auth;
		$this->client = $client;
	}
	
	private function login(){
		// $citymobile = \app\models\Agregator::find()->where(['name' => 'Ситимобиль'])->one();
		// $client = new \yii\httpclient\Client();
		// $client = new \yii\httpclient\Client(['baseUrl'=> $citymobile->apiv1]);
		
		$content = [
					"login" => $this->auth['login'],
					"password" => $this->auth['password']
				];
		// return json_encode($content);
		$response = $this->client->createRequest()
							->setMethod('post')
							->addHeaders(['content-type' => 'application/json'])
							->setUrl('/user/identity')
							->setFormat(\yii\httpclient\Client::FORMAT_JSON)
							->setData(
								$content
							)
							->send();
		return $response->data;		
		return $response->isOk? $response->data : $response;
		
	}
	public function register(){
		$token = $this->login()['token'];
		$content = [
						"fields" => [
							"name" => $this->profile->firstname,
							"last_name" => $this->profile->lastname,
							"middle_name" => $this->profile->secondname,
							"login" => $this->profile->phone,
							"birthday" => $this->profile->birthdate,
							"phone_number" => $this->profile->phone,
							"document_type" => 12,
							"document_number" =>  $this->profile->passport_series . $this->profile->passport_number,
							"document_from" => $this->profile->passport_giver,
							"document_start_date" => $this->profile->passport_date,
							"driver_license_class" => "B",
							"driver_license_type" => 8,
							"driver_license_number" => $this->profile->license_series . $this->profile->license_number
						]
					// "name" => "Пётр",
					// "last_name" => $this->profile->lastname,
					// "middl" => $this->profile->secondname,
					// "login" => $this->profile->phone,
					// "birthday" => $this->profile->birthdate,
					// "phone_number" => $this->profile->phone,
					// "document_type" => 12,
					// "document_number" =>  $this->profile->passport_series . $this->profile->passport_number,
					// "document_from" => $this->profile->passport_giver,
					// "document_start_date" => $this->profile->passport_date,
					// "driver_license_class" => "B",
					// "driver_license_type" => 8,
					// "driver_license_number" => $this->profile->license_series . $this->profile->license_number
				];

		// return $content;
		// return json_encode($content);
		$response = $this->client->createRequest()
							->setMethod('post')
							->addHeaders([
								'content-type' => 'application/json',
								'Authorization' => "Bearer $token"
							])
							->setUrl('/driver/create')
							->setFormat(\yii\httpclient\Client::FORMAT_JSON)
							->setData(
								$content
							)
							->send();
		return $response;
	}
}