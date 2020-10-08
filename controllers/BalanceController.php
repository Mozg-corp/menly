<?php

namespace app\controllers;
use Yii;
use app\models\BalanceGet;
use app\models\BalanceYandex;
use app\models\BalanceCitymobil;
use yii\web\Controller;
use Guzzle\HttpClient\Client;

final class BalanceController extends \yii\web\Controller
{

public function actionGet(){
    try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceGet();
    $Balance->GetArray('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Get:', $e->getMessage();
      }
}

public function actionYandex(){
//// https://fleet-api.taxi.yandex.net


try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceYandex('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Yandex:', $e->getMessage();
      }

}
public function actionCitymobil(){
//// https://fleet.city-mobil.ru/api/doc
try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceCitymobil('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Citymobil:', $e->getMessage();
      }

}
}