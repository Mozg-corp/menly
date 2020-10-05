<?php
/**
 * Api для регистрации по ссылке
 * @var ArrayRequestRegistrations = Массив данных для регистрации
 * ["User" => 'Имя пользователя',
 *  "Password" => 'Пароль',
 *  ]
 */

/*
**05.10.20(16.23)
Код не даработан. Не доразобранна логика регистрации через Api
 actionRegistrationurl() -> Не лучший вориант отработки логики
 actionRegistrationpost() -> Лучший вориант отработки логики
 ( \Yii::$app->auth->signUp($model);) -> Придерживаться следующей логики для записи в бд
**
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

public function actionRegistrationurl($phone,$password,$token){
//
    try {
         $ResponseUrl = Yii::$app->request->get();
         $PhoneUser = $ResponseUrl["phone"];
         $Password = $ResponseUrl["password"];
         $Token = $ResponseUrl["token"];
         //-Запись в бд----------//
         $RegistrationUserUrl = new User();
         $RegistrationUserUrl->phone = $PhoneUser;
         $RegistrationUserUrl->password = $Password;
         $RegistrationUserUrl->save();
         } catch (Exception $e) {
            echo 'Выброшено исключение в функции actionRegistration: ', $e->getMessage();
            die();
        }
        return "This good!";
        // return $this->render('index');
}
public function actionRegistrationpost(){
 try {
         $ResponsePost = Yii::$app->request->get();
         $PhoneUser = $_POST["phone"];
         $Password = $_POST["password"];
         $Token = $_POST["token"];
         //-Запись в бд----------//
         $RegistrationUserPost = new User();
         $RegistrationUser->phone = $PhoneUser;
         $RegistrationUser->password = $Password;
         \Yii::$app->auth->signUp($model);

        } catch (Exception $e) {
            echo 'Выброшено исключение в функции actionRegistration: ', $e->getMessage();
            die();
        }
}

}