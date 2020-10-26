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
	public function actionGo(){
		$promise = $this->client->getCityBalance('786565');
		try{
			$response = $promise->wait();
		}catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody()->getContents();
			$responseStdObj = json_decode($responseBodyAsString);
			print_r($responseStdObj);
			die;
		}
		return json_encode($promise);
	}
	public function actionCityGrow(){
		$raw_drivers = file_get_contents('../raw/citymobile driver list.json');
		$drivers = json_decode($raw_drivers);
		forEach($drivers->drivers as $driver){
			$user = new \app\models\User();
			$user->phone = $driver->phone_number;
			$user->password = "menly_4ever";
			$user->password_repeat = "menly_4ever";
			$user->scenarioSignUp();
			\Yii::$app->auth->signUp($user);
			$user_created = \app\models\User::find()->where(['phone' => $driver->phone_number])->one();
			$profile = new \app\models\ProfileBase();
			$profile->firstname = $driver->name;
			$profile->secondname = $driver->middle_name;
			$profile->lastname = $driver->last_name;
			$profile->user_id = $user_created->id;
			$profile->phone = $driver->phone_number;
			$profile->save();
			$profile_created = \app\models\Profile::find()->where(['user_id' => $user_created->id])->one();
			if($user_created){
				$user_agregator = new \app\models\UserAgregator();
				$user_agregator->users_id = $user_created->id;
				$user_agregator->agregators_id = 2;
				$user_agregator->save();
				$driver_account = new \app\models\DriverAccount();
				$driver_account->id_agregator = 2;
				$driver_account->id_account_types = 1;
				$driver_account->id_users = $user_created->id;
				$driver_account->account = $driver->login;
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
		$dt->setTimestamp(1603693804);
		var_dump($dt, (new \DateTime())->setTimestamp(time()));
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
	public function actionRide(){
		$data = json_decode(' {
                "driver_id": 422566,
                "driver_name": "Калиничев Андрей Владиславович",
                "order_id": 1348851134,
                "division": "moscow comfort",
                "scheduled_at": "2020-09-08 19:52:06",
                "ended_at": "2020-09-08 20:14:54",
                "origin_full_address": "Станционная улица, Москва",
                "collected_from_client": "0.00",
                "cost_for_driver": "290.00",
                "driver_order_balance": "290.00",
                "driver_tips": "0.00",
                "coupon": "0.00",
                "payment_type": "Credit_card",
                "full_tips": "0.00",
                "cost_for_driver_wo_tips": "290.00",
                "pwg_reward": null,
                "fact_ride_estimate": "00:13:29",
                "recorded_waiting_time": "00:00:20",
                "destination_full_address": "улица Академика Комарова, д. 5В, Москва",
                "distance": 3.6,
                "parking_cost": null,
                "action_summ": null
            }');
		$ride = new \app\models\Ride();
		$ride->fillFromRideData($data);
		
		$order = new \app\models\GettOrder();
		$order->fillFromRide($ride);
		$order->save();
		print_r($order->errors);
		$balance = /*new \app\models\GettBalance();// = */ \app\models\GettBalance::find()->byDriver($ride)->one();
		if($balance){
			$balance->accumulateRide($ride);
			echo 'gffg'.'\n';
		}else{
			$balance = new \app\models\GettBalance();
			$balance->fillFromRide($ride);
			echo 'fggf'.'\n';
		}
		if($balance->save()){
			print_r($balance);
		}else{
			print_r($balance->errors);
		}
	}
	public function actionFindUser(){
		$gett = \app\models\Agregator::find()->getAgregatorByName('Gett');
		$user = \app\models\User::find()
							->joinWith('driverAccounts')
							->where(['account' => 137521])
							->andWhere(['id_agregator' => $gett->id])
							->one();
		print_r($user);
	}
	public function actionFindOrder(){
		$order = \app\models\GettOrder::find()->findOrderByRide(1348851134)->one();
		print_r($order);
	}
	public function actionProccessReport(){
		$ride_data_raw = file_get_contents('../raw/gett_report_3.json');
		$ride_data = json_decode($ride_data_raw);
		// $ride_data = json_decode('{
			// "driver_id":422566,
			// "driver_name":"\u0421\u043b\u0430\u0434\u043a\u043e\u0432 \u0410\u043d\u0434\u0440\u0435\u0439 \u041d\u0438\u043a\u043e\u043b\u0430\u0435\u0432\u0438\u0447",
			// "order_id":1354431427,
			// "division":"sp visa business",
			// "scheduled_at":"2020-09-16 17:58:26",
			// "ended_at":"2020-09-16 18:21:10",
			// "origin_full_address":"\u041a\u0430\u0437\u0430\u043d\u0441\u043a\u0430\u044f \u0443\u043b\u0438\u0446\u0430, \u0434. 3\u0430, \u0421\u0430\u043d\u043a\u0442-\u041f\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433",
			// "collected_from_client":"0.00",
			// "cost_for_driver":"783.00",
			// "driver_order_balance":"783.00",
			// "driver_tips":"0.00",
			// "coupon":"0.00",
			// "payment_type":"Credit_card",
			// "full_tips":"0.00",
			// "cost_for_driver_wo_tips":"783.00",
			// "pwg_reward":null,
			// "fact_ride_estimate":"00:20:34",
			// "recorded_waiting_time":"00:01:42",
			// "destination_full_address":"\u041a\u0440\u0435\u043c\u0435\u043d\u0447\u0443\u0433\u0441\u043a\u0430\u044f \u0443\u043b\u0438\u0446\u0430, \u0434. 13\u043a2, \u0421\u0430\u043d\u043a\u0442-\u041f\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433",
			// "distance":4,
			// "parking_cost":700,
			// "action_summ":null}');
		// print_r($ride_data);
		$grs = new \app\services\GettReportService($ride_data->data->rides);
		// $grs = new \app\services\GettReportService([$ride_data]);
		$grs->calculateBalances();
	}
	public function actionUserExist(){
		$data = json_decode('{
			"driver_id":422566,
			"driver_name":"\u0421\u043b\u0430\u0434\u043a\u043e\u0432 \u0410\u043d\u0434\u0440\u0435\u0439 \u041d\u0438\u043a\u043e\u043b\u0430\u0435\u0432\u0438\u0447",
			"order_id":1354431427,
			"division":"sp visa business",
			"scheduled_at":"2020-09-16 17:58:26",
			"ended_at":"2020-09-16 18:21:10",
			"origin_full_address":"\u041a\u0430\u0437\u0430\u043d\u0441\u043a\u0430\u044f \u0443\u043b\u0438\u0446\u0430, \u0434. 3\u0430, \u0421\u0430\u043d\u043a\u0442-\u041f\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433",
			"collected_from_client":"0.00",
			"cost_for_driver":"783.00",
			"driver_order_balance":"783.00",
			"driver_tips":"0.00",
			"coupon":"0.00",
			"payment_type":"Credit_card",
			"full_tips":"0.00",
			"cost_for_driver_wo_tips":"783.00",
			"pwg_reward":null,
			"fact_ride_estimate":"00:20:34",
			"recorded_waiting_time":"00:01:42",
			"destination_full_address":"\u041a\u0440\u0435\u043c\u0435\u043d\u0447\u0443\u0433\u0441\u043a\u0430\u044f \u0443\u043b\u0438\u0446\u0430, \u0434. 13\u043a2, \u0421\u0430\u043d\u043a\u0442-\u041f\u0435\u0442\u0435\u0440\u0431\u0443\u0440\u0433",
			"distance":4,
			"parking_cost":300,
			"action_summ":null}');
		$ride = new \app\models\Ride();
		$ride->fillFromRideData($data);
		
		if($ride->userExist()) print_r('ok');
		else echo 'no';
	}
}
