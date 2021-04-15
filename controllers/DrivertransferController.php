<?php

namespace app\controllers;
use Yii;

use yii\web\Controller;
use app\models\DriversArrayParser;

final class DrivertransferController extends \yii\web\Controller
{

public function actionReadygo(){

\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

try{
/// TODO: есть 3 массива выкинуть из них повторы

        		$raw_drivers_citymobile = file_get_contents('TEST/citymobile_driver_list.json');
		$CitymobileDrivers = json_decode($raw_drivers_citymobile,true);
		$CitymobileDrivers = $CitymobileDrivers["drivers"];
		        $raw_drivers_gett = file_get_contents('TEST/gett_drivers_list.json');
		$GettDrivers = json_decode($raw_drivers_gett,true);
		$GettDrivers = $GettDrivers["data"];
		        $raw_drivers_yandex = file_get_contents('TEST/yandex_drivers_list.json');

		$YandexDrivers = json_decode($raw_drivers_yandex,true);
       $YandexDrivers = $YandexDrivers['driver_profiles'];



      			   $Parser = new DriversArrayParser();
                   $Parser->YandexDrivers($YandexDrivers);  // 1
       			   $Parser->GettDrivers($GettDrivers);      // 1
       			   $Parser->CitymobileDrivers($CitymobileDrivers); // 33
       			   $Response = $Parser->AddToDB();



		return $Response;
		//[$CitymobileDrivers,$GettDrivers,$YandexDrivers];
	}catch(Exception $e) {
    echo 'Выброшено исключение в контролере DriversyandexController функции actionGet:', $e->getMessage();
      }



  }
}