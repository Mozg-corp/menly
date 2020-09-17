<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RestController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $client = new Client(['baseUrl'=>'https://fleet-api.taxi.yandex.net']);
		$request = $client->createRequest()
							->setMethod('post')
							->addHeaders(['content-type' => 'application/json'])
							->addHeaders(['X-API-Key' => 'ZmrOTXOvioph+fEQLPyNRiMEDKQXXz+adlcIpo'])
							->addHeaders(['X-Client-ID' => 'taxi/park/8e974b78dc284add96cf02515098d1e2'])
							->setUrl('v1/parks/driver-profiles/list')
							->setFormat(Client::FORMAT_JSON)
							->setContent(
								'{"fields": {"driver_profile": []}, "limit": 10, "query": {"park": {"car": {  }, "id": "8e974b78dc284add96cf02515098d1e2"}}}'
							)
							->send();
       return $request;
    }
	public function actionArp(){
		$am = \Yii::$app->authManager;
        $rule = new \app\rules\ProfileOwnerRule();
		$am->removeRule($rule);
		// $viewOwnProfile= $authManager->createPermission('viewOwnProfile');
        // $viewOwnProfile->description = 'Просмотр и редактирование своего профиля';

        // $rule = new \app\rules\ProfileOwnerRule();
        // $viewOwnProfile->ruleName = $rule->name;

        // $authManager->add($rule);
        // $authManager->add($viewOwnProfile);
		// $candidate = $authManager->getRole('candidate');
		// $authManager->addChild($candidate, $viewOwnProfile);
	}
	public function actionAp(){
		$authManager = \Yii::$app->authManager;
		
		// $createProfile= $authManager->createPermission('createProfile');
        // $createProfile->description = 'Создание любых видов сущностей';
        // $authManager->add($createProfile);
		
		$candidate = $authManager->getRole('candidate');
		$admin = $authManager->getRole('admin');
        $authManager->addChild($admin, $candidate);

	}
	public function actionTest(){
		$userId = 1;
		\Yii::$app->user->loginByAccessToken('k2CPENB9Jv7NcvhvVC00Wp4SuvN0N7Lb');
		echo $userId.PHP_EOL;
		echo \app\models\Profile::find()->where(['user_id' => $userId])->one()->user_id.PHP_EOL;
		 if(\app\models\Profile::find()->where(['user_id' => $userId])->one()->user_id == $userId){
			 
			'dfsgfsdfg'.PHP_EOL;
		 }
		if(\Yii::$app->authManager->checkAccess('viewOwnProfile', [ 'profile' => \app\models\Profile::find()->where(['user_id' => $userId])->one()])){
			'fgdghgf'.PHP_EOL;
		}
	}
	public function actionLogin(){
		$auth = file_exists(@app.'/config/citymobile_auth_local.php')
			? (require @app.'/config/citymobile_auth_local.php')
			: [];
		$registerer = new \app\services\CitymobileProfileRegister(new \app\models\Profile(), $auth);
		$response = $registerer->register();
		print_r($response);
	}
	
}
