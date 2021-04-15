<?php

namespace app\controllers;
use Yii;

use yii\web\Controller;
use app\models\Back_UP_BD;

final class BackupbdController extends \yii\web\Controller
{

public function actionCheckready(){



\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

try{

    $Backup = new Back_UP_BD();
    $Backup->setArryIN([0=>['phones','users','car'],1=>['phones','users','car']); // Массив данных
    $Backup->CheckReady(); // Проверяем готовность
    $Backup->StartTransactionTo(["YandexDrivers","Gett"]);


    return $Response->ArrayResponseDrivers;
}catch(Exception $e) {
    echo 'Выброшено исключение в контролере DriversyandexController функции actionGet:', $e->getMessage();
      }



  }
}