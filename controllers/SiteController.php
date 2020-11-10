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
	public function actionCityGrow(){
		$raw_drivers = file_get_contents('../raw/citymobile driver list.json');
		$drivers = json_decode($raw_drivers);
		forEach($drivers->drivers as $driver){
			// $user = new \app\models\User();
			// $user->phone = $driver->phone_number;
			// $user->password = "menly_4ever";
			// $user->password_repeat = "menly_4ever";
			// $user->scenarioSignUp();
			// \Yii::$app->auth->signUp($user);
			$user_created = \app\models\User::find()->where(['phone' => $driver->phone_number])->one();
			// $profile = new \app\models\ProfileBase();
			// $profile->firstname = $driver->name;
			// $profile->secondname = $driver->middle_name;
			// $profile->lastname = $driver->last_name;
			// $profile->user_id = $user_created->id;
			// $profile->phone = $driver->phone_number;
			// $profile->save();
			// $profile_created = \app\models\Profile::find()->where(['user_id' => $user_created->id])->one();
			if($user_created){
				$user_agregator = new \app\models\UserAgregator();
				$user_agregator->users_id = $user_created->id;
				$user_agregator->agregators_id = 2;
				$user_agregator->save();
				$driver_account = new \app\models\DriverAccount();
				$driver_account->id_agregator = 2;
				$driver_account->id_account_types = 1;
				$driver_account->id_users = $user_created->id;
				$driver_account->account = $driver->uuid;
				$driver_account->save();
			}
			//// print_r($driver);
		}
		echo "done";
	}
	public function actionTime(){
		// $date = new \DateTime();
		// $date->add(new \DateInterval("PT3H"));
		// $to = $date->format('Y-m-d H:i:s');
		// echo $to.PHP_EOL;
		// $date->sub(new \DateInterval("P30D"));
		// $from = $date->format('Y-m-d H:i:s');
		// echo $from;
		$dt = new \DateTime();
		
		// echo $dt->format('Y-m-dTH:i:sP');
		echo $dt->format('c');
		
		// $dt->setTimestamp(1603693804);
		// var_dump($dt, (new \DateTime())->setTimestamp(time()));
	}
	public function actionTransactionsYandex(){
		$payload = [];
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Europe/Moscow'));
		// $date->add(new \DateInterval("PT3H"));
		$to = $date->format('c');
		$date->sub(new \DateInterval("P180D"));
		$from = $date->format('c');
		$payload['to'] = $to;
		$payload['from'] = $from;
		// $payload['from'] = "2020-01-13T15:24:13+03:00";//"2020-10-13T15:24:41+03:00";
		// $payload['to'] = "2020-10-30T15:24:13+03:00";//"2020-10-30T15:24:41+03:00";
		// $payload['from'] = "2020-01-13T15:24:41+03:00";
		// $payload['to'] = "2020-10-30T15:24:41+03:00";
		// $payload['to'] = "2020-01";
		// $payload['from'] = $from;
		$payload['driverId'] = "7eb247e665794fcfba3d2af423e3e85f";
		// print_r($payload);die;
		$promise = $this->client->getTransactionsByName('Яндекс', $payload);
		$response = $promise->wait();
		print_r($response->getBody()->getContents());
	}
	public function actionGettGrow(){
		$raw_drivers = file_get_contents('../raw/gett drivers list.json');
		$drivers = json_decode($raw_drivers);
		forEach($drivers->data as $driver){
			$user = new \app\models\User();
			$user->phone = $driver->phone;
			$user->password = "menly_4ever";
			$user->password_repeat = "menly_4ever";
			$user->scenarioSignUp();
			\Yii::$app->auth->signUp($user);
			
			$user_created = \app\models\User::find()->where(['phone' => $driver->phone])->one();
			$profile = new \app\models\ProfileBase();
			$fio = explode(' ', $driver->name);
			$profile->firstname = $fio[0];
			$profile->secondname = count($fio) > 2 ? $fio[1] : '';
			$profile->lastname = count($fio) > 2 ? $fio[2] : $fio[1];
			$profile->user_id = $user_created->id;
			$profile->phone = $driver->phone;
			$profile->save();
			
			$user_agregator = new \app\models\UserAgregator();
			$user_agregator->users_id = $user_created->id;
			$user_agregator->agregators_id = 3;
			$user_agregator->save();
			
			$driver_account = new \app\models\DriverAccount();
			$driver_account->id_agregator = 3;
			$driver_account->id_account_types = 1;
			$driver_account->id_users = $user_created->id;
			$driver_account->account = (string)$driver->driver_id;
			$driver_account->save();
			print_r($driver_account->errors);
		}
		echo "done";
	}
	public function actionYandexGrow(){
		$raw_drivers = file_get_contents('../raw/yandex drivers list.json');
		$drivers = json_decode($raw_drivers);
		//print_r($drivers->driver_profiles[0]->driver_profile->phones[0]);
		forEach($drivers->driver_profiles as $driver){
			// $user = new \app\models\User();
			// $user->phone = substr($driver->driver_profile->phones[0], 1);
			// $user->password = "menly_4ever";
			// $user->password_repeat = "menly_4ever";
			// $user->scenarioSignUp();
			// \Yii::$app->auth->signUp($user);
			$phone = substr($driver->driver_profile->phones[0], 1);
			$user_created = \app\models\User::find()->where(['phone' => $phone])->one();
			// $profile = new \app\models\ProfileBase();
			// $profile->firstname = $driver->driver_profile->first_name;
			// $profile->secondname = $driver->driver_profile->middle_name??'';
			// $profile->lastname = $driver->driver_profile->last_name;
			// $profile->user_id = $user_created->id;
			// $profile->phone = $phone;
			//print_r($profile);
			// $profile->save();
			if($user_created){
				$profile_created = \app\models\Profile::find()->where(['user_id' => $user_created->id])->one();
				$user_agregator = new \app\models\UserAgregator();
				$user_agregator->users_id = $user_created->id;
				$user_agregator->agregators_id = 1;
				$user_agregator->save();
				$driver_account = new \app\models\DriverAccount();
				$driver_account->id_agregator = 1;
				$driver_account->id_account_types = 1;
				$driver_account->id_users = $user_created->id;
				$driver_account->account = $driver->accounts[0]->id;
				$driver_account->save();
			}
			//// print_r($driver);
		}
		echo "done";
	}
	public function actionAddUsers(){
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$initRepo = new \app\repositories\InitAgregatorsAlreadyExistsUsers();
		$initRepo->readJson([
			'Ситимобиль' => '../raw/citymobile driver list.json',
			'Яндекс' => '../raw/yandex drivers list.json',
			'Gett' => '../raw/gett drivers list.json'
		]);
		$initRepo->saveUsersToDb();
		return $initRepo->users;
	}
}
