<?php
/**
 * Api для регистрации по ссылке
 * @var ArrayRequestRegistrations = Массив данных для регистрации
 * ["User" => 'Имя пользователя',
 *  "Password" => 'Пароль',
 *  ]
 */
namespace app\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\web\Response;
use app\components\RbacComponent;

class ApiauthController extends \yii\web\Controller
{

public actionRegistration($ArrayRequestRegistrations){







    try {
        const  $RESOURSE = Yii::$app->request->get();

        } catch (Exception $e) {
            echo 'Выброшено исключение в функции actionRegistration: ', $e->getMessage();
            die();
        }

}

}