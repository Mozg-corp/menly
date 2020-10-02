<?php
/**
 * Api для регистрации по ссылке
 * @var ArrayRequestRegistrations = Массив данных для регистрации
 * ["User" => 'Имя пользователя',
 *  "Password" => 'Пароль',
 *  ]
 */
namespace app\controllers;
use Yii;
use app\models\User;
use yii\helpers\Json;
use yii\web\Response;
use app\components\RbacComponent;
 // \yii\rest\Controller
class ApiauthController extends \yii\rest\Controller
{

public function actionRegistration($phone,$password,$token,$key){
//
    try {
         $ResponseUrl = Yii::$app->request->get();
         $PhoneUser = $ResponseUrl["phone"];
         $PasswordPassword = $ResponseUrl["password"];
         $PasswordToken = $ResponseUrl["token"];
         $PasswordKey = $ResponseUrl["key"];
         //var_dump($ResponseUrl);
         //die();

        } catch (Exception $e) {
            echo 'Выброшено исключение в функции actionRegistration: ', $e->getMessage();
            die();
        }
        return "This good!";
        // return $this->render('index');
}

}