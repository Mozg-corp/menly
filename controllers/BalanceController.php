<?php

namespace app\controllers;
use Yii;
use app\models\BalanceGet;
use yii\web\Controller;

final class BalanceController extends \yii\web\Controller
{

public function actionGet(){
    try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceGet('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Get:', $e->getMessage();
      }
}


}