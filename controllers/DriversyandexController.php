<?php

namespace app\controllers;
use Yii;

use yii\web\Controller;
use app\models\YandexDrivers;

final class DriversyandexController extends \yii\web\Controller
{

public function actionGet(){



\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

try{

    $YandexDriversResponse = new YandexDrivers();
    $Response = $YandexDriversResponse->GetArrayDrivers('http://menly/TEST.json');
    return $Response->ArrayResponseDrivers;
}catch(Exception $e) {
    echo 'Выброшено исключение в контролере DriversyandexController функции actionGet:', $e->getMessage();
      }



  }
}