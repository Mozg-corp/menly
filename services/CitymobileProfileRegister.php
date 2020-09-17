<?php namespace app\services;

$auth = file_exists('@app/config/citimobile_auth_local.php')
			? (require '@app/config/citimobile_auth_local.php')
			: [];

use app\interfaces\RegisterInterface;

class CitymobileProfileRegister implements RegisterInterface{
	private $profile;
	private $auth;
	public function __construct(\yii\db\ActiveRecord $profile, $auth){
		$this->profile = $profile;
		$this->auth = $auth;
	}
	
	public function register(){
		$citymobile = \app\models\Agregator::find()->where(['name' => 'Ситимобиль'])->one();
		$client = new \yii\httpclient\Client(['baseUrl'=>$citymobile->apiv1]);
		$client = new \yii\httpclient\Client(['baseUrl'=> $citymobile->apiv1]);
		$content = '\{\"username\":'.$this->auth['login'].'\"password\":' . '\"'.$this->auth['password']).'\"}';
		return $content;
		// $response = $client->createRequest()
							// ->setMethod('post')
							// ->addHeaders(['content-type' => 'application/json'])
							// ->setUrl('/user/identity')
							// ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
							// ->setContent(
								// $content
							// )
							// ->send();
		// return $response;
		// $request = $client->createRequest()
							// ->setMethod('post')
							// ->addHeaders(['content-type' => 'application/json'])
							// ->addHeaders(['Authorization' => 'ZmrOTXOvioph+fEQLPyNRiMEDKQXXz+adlcIpo'])
							// ->addHeaders(['X-Client-ID' => 'taxi/park/8e974b78dc284add96cf02515098d1e2'])
							// ->setUrl('v1/parks/driver-profiles/list')
							// ->setFormat(Client::FORMAT_JSON)
							// ->setContent(
								// '{"fields": {"driver_profile": []}, "limit": 10, "query": {"park": {"car": {  }, "id": "8e974b78dc284add96cf02515098d1e2"}}}'
							// )
							// ->send();
	}
}