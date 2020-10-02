<?php

namespace app\controllers;

use app\lib\ibuypro\Graph;
use app\lib\ibuypro\IbuyproAlgorithm;
// use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\RbacComponent;
use app\models\Post;
use app\models\User;
use yii\base\Component;


class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'docs' => [
                'class' => 'app\controllers\actions\site\SwaggerUIRenderer',
                'restUrl' => \yii\helpers\Url::to(['site/json-schema']),
            ],
            'json-schema' => [
                'class' => 'app\controllers\actions\site\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    \Yii::getAlias('@app/controllers'),
                    \Yii::getAlias('@app/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


	
	// public function actionAddadmin(){
		// $admin = new User();
		// $admin->phone = "79251234567";
		// $admin->password = 'menly_4ever';
		// $admin->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($admin->password);
        // $admin->auth_key = \Yii::$app->getSecurity()->generateRandomString();
        // $admin->token = \Yii::$app->getSecurity()->generateRandomString();

        // if($admin->save()){
            // return true;
        // }else{
			// print_r($admin->errors);
		// }
	// }
	public function actionTest($id){
		//print_r(\Yii::$app->authManager->getPermissionsByUser(\Yii::$app->user->getId()));
		//\Yii::$app->user->loginByAccessToken('k2CPENB9Jv7NcvhvVC00Wp4SuvN0N7Lb');\app\models\Profile::findOne($id)]
		$profile = new \app\models\Profile();
		$profile->id =90;
        if(\Yii::$app->user->can('viewOwnProfile', [ 'profile' => $profile])){
			return 'ok';
		}else{
			return 'bad';
		}
	}
	// public function actionAddPermission(){
		// $am = \Yii::$app->authManager;
		
		// $admin= $am->getRole('admin');
		
		// $viewAllCars= $am->createPermission('updateAnyCar');
        // $viewAllCars->description = 'Изменение любой машины';

        // $am->add($viewAllCars);
		// $am->addChild($admin, $viewAllCars);
	// }
	// public function actionDeletePermission(){
		// $am = \Yii::$app->authManager;
		// $p = $am->getPermission('createProfile');
		// $am->remove($p);
		// $r = $am->getRule('carOwnerRule');
		// $am->remove($r);
		// $admin= $am->getRole('admin');
		
		// $viewAllCars= $am->createPermission('updateAnyCar');
        // $viewAllCars->description = 'Изменение любой машины';

        // $am->add($viewAllCars);
		// $am->addChild($admin, $viewAllCars);
	//}
	public function actionSee(){

		$auth = file_exists('/'.@app.'/config/citymobile_auth_local.php')
			? (require '/'.@app.'/config/citymobile_auth_local.php')
			: [];
		$citymobile = \app\models\Agregator::find()->where(['name' => 'Ситимобиль'])->one();
		$client = new \yii\httpclient\Client(['baseUrl'=> $citymobile->apiv1]);
		$profile = \app\models\Profile::findOne(37);
		$registerer = new \app\services\CitymobileProfileRegister($profile, $auth, $client);
		$response = $registerer->register();
		// print_r(require '/'.@app.'/config/citymobile_auth_local.php');
		print_r($response);
	}
	public function actionGuzzle(){
		$ag = \app\models\Agregator::find()->select(['name','token','refresh_token','expire'])->where(['name' => ['Ситимобиль','Gett']])->all();
		print_r($ag[1]);
		// if(){}else{
			// \Yii::$app->async->run(new \app\async\CityAuthLoader());
			// \Yii::$app->async->run(new \app\async\GettAuthLoader());
			// $auths = \Yii::$app->async->wait();
			// $citymobile = new \app\services\CitymobileService($auths[0]);
			// $gett = new \app\services\GettService($auths[1]);
			// $agregators = [
							// \app\services\CitymobileService::NAME => $citymobile, 
							// \app\services\GettService::NAME => $gett
						// ];
			// $client = new \app\services\HttpClientService($agregators, ['headers' => [
																						// 'Content-Type' => 'application/json'
																					  // ]
																		// ]);

			// $responses = $client->loginAll();
			// forEach($agregators as $name => $agregatorService){
				// $body = json_decode($responses[$name]['value']->getBody()->getContents());
				// $agregator = \app\models\Agregator::find()->getAgregatorByName($name);;
				// $agregator->token = isset($body->token)?$body->token:$body->access_token;
				// $agregator->refresh_token = isset($body->refresh_token)?$body->refresh_token:null;
				// $agregator->expire = time() + 7200;
				// $agregator->save();
			// }
		// }
		//return;
		// return json_encode((new \app\services\CitymobileService())->loginRequest());
		return json_encode($responses, JSON_UNESCAPED_UNICODE);
		//print_r($responses['gett']['reason']);
		// print_r($responses);
	}
	public function actionAgregators(){
		$agr = \app\models\Agregator::find()->findAgregatorByName('Ситимобиль');

		print_r($agr);
	}
	public function actionF(){
		$d = \app\models\User::findOne(3);
		// print_r($d->usersAgregators[1]->agregators);
		print_r($d->agregators);
	}
}
