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
	private $client;
	public function __construct($id, $module, \app\interfaces\ClientInterface $client, $config=[]){
		$this->client = $client;
		parent::__construct($id, $module, $config);
	}

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
		$agr = \app\models\Agregator::find()->getAgregatorByName('Ситимобиль');

		print_r($agr);
	}
	public function actionF(){
		$d = \app\models\User::findOne(3);
		// print_r($d->usersAgregators[1]->agregators);
		
		print_r($d->agregatorsNames);
	}
	public function actionD(){
		$d = \app\models\User::findOne(3);
		return print_r(\app\models\Agregator::find()->getApiByName('Gett'));
	}
	public function actionT(){
		$user = \app\models\User::findOne(3);
		$userAgregators = $user->agregatorsNames;
		$client = new \app\services\HttpClientService();
		// $promises = [];
		// forEach($userAgregators as $agregator){
			// $promises[$agregator] = $client->logInAgregator($agregator);
		// }
		//print_r($promises); exit;
		//$promises['Ситимобиль'] = $client->logInAgregator('Ситимобиль');
		//print_r($promise);
		// $responses = \GuzzleHttp\Promise\settle($promises)->wait();
		$loginService = new \app\services\LoginService($client);
		$tokens = $loginService->loginAll($userAgregators);
		print_r($tokens);
	}
	public function actionB(){
		$client = new \app\services\HttpClientService();
		$loginService = new \app\services\LoginService($client);
		$tokens = $loginService->login('Ситимобиль');
		print_r($tokens);
	}
	public function actionGo(){
		return $this->client->obtainToken('Ситимобиль');
	}
	public function actionBalance(){
		$reportRaw = file_get_contents('../raw/gett report.json');
		$report = json_decode($reportRaw);
		// $gs = new ();
		print_r(
		 \app\services\GettService::getBalances($report->data->rides)
		);
	}
	public function actionCreateReport(){
		// $date = new \DateTime();
		// $date->add(new \DateInterval("PT3H"));
		// echo $date->format('Y-m-d H:i:s').PHP_EOL;
		// $date->sub(new \DateInterval("P30D"));
		// echo $date->format('Y-m-d H:i:s');
		return $this->client->createGettReport();
	}
	public function actionYaBalance(){
		return $this->client->getYandexBalance("0e19f22e02004b44a1ff395ae83e711a");
	}
	public function actionCityBalance(){
		//
		return $this->client->getCityBalance("786565");
	}
	public function actionGettReport(){
		$promise_create =  $this->client->createGettReport();
		$response_create = $promise_create->wait();
		print_r($response);
		echo PHP_EOL;
		$body_create = json_decode($response_create->getBody()->getContents());
		if($body_create->result === true){
			$uid = $body_create->uid;
			echo $uid .PHP_EOL;
			sleep(60);
			$promise_report = $this->client->readGettReport($uid);
			$response_report = $promise_report->wait();
			$body_report= json_decode($response_report->getBody()->getContents());
			print_r($body_report);
		}else{
			print_r('bad create'.PHP_EOL .$body);
		}
	}
	public function actionCityGrow(){
		// $raw_drivers = file_get_contents('../raw/citymobile driver list.json');
		// $drivers = json_decode($raw_drivers);
		// forEach($drivers->drivers as $driver){
			// $user = new \app\models\User();
			// $user->phone = $driver->phone_number;
			// $user->password = "menly_4ever";
			// $user->password_repeat = "menly_4ever";
			// $user->scenarioSignUp();
			// \Yii::$app->auth->signUp($user);
			//$user_created = \app\models\User::find()->where(['phone' => $driver->phone_number])->one();
			// $profile = new \app\models\ProfileBase();
			// $profile->firstname = $driver->name;
			// $profile->secondname = $driver->middle_name;
			// $profile->lastname = $driver->last_name;
			// $profile->user_id = $user_created->id;
			// $profile->phone = $driver->phone_number;
			// $profile->save();
			//// $profile_created = \app\models\Profile::find()->where(['user_id' => $user_created->id])->one();
			// $user_agregator = new \app\models\UserAgregator();
			// $user_agregator->users_id = $user_created->id;
			// $user_agregator->agregators_id = 2;
			// $user_agregator->save();
			// $driver_account = new \app\models\DriverAccount();
			// $driver_account->id_agregator = 2;
			// $driver_account->id_account_types = 1;
			// $driver_account->id_users = $user_created->id;
			// $driver_account->account = $driver->login;
			// $driver_account->save();
			// print_r($driver);
		// }
		// echo "done";
	}
	public function actionTime(){
		$date = new \DateTime();
		$date->add(new \DateInterval("PT3H"));
		$to = $date->format('Y-m-d H:i:s');
		echo $to.PHP_EOL;
		$date->sub(new \DateInterval("P30D"));
		$from = $date->format('Y-m-d H:i:s');
		echo $from;
	}
	public function actionGettGrow(){
		// $raw_drivers = file_get_contents('../raw/gett drivers list.json');
		// $drivers = json_decode($raw_drivers);
		// forEach($drivers->data as $driver){
			// $user = new \app\models\User();
			// $user->phone = $driver->phone;
			// $user->password = "menly_4ever";
			// $user->password_repeat = "menly_4ever";
			// $user->scenarioSignUp();
			// \Yii::$app->auth->signUp($user);
			
			// $user_created = \app\models\User::find()->where(['phone' => $driver->phone])->one();
			// $profile = new \app\models\ProfileBase();
			// $fio = explode(' ', $driver->name);
			// $profile->firstname = $fio[0];
			// $profile->secondname = count($fio) > 2 ? $fio[1] : '';
			// $profile->lastname = count($fio) > 2 ? $fio[2] : $fio[1];
			// $profile->user_id = $user_created->id;
			// $profile->phone = $driver->phone;
			// $profile->save();
			
			// $user_agregator = new \app\models\UserAgregator();
			// $user_agregator->users_id = $user_created->id;
			// $user_agregator->agregators_id = 3;
			// $user_agregator->save();
			
			// $driver_account = new \app\models\DriverAccount();
			// $driver_account->id_agregator = 3;
			// $driver_account->id_account_types = 1;
			// $driver_account->id_users = $user_created->id;
			// $driver_account->account = $driver->driver_id;
			// $driver_account->save();
		// }
		// echo "done";
	}
}
