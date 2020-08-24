<?php

namespace app\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\web\Response;
use app\components\RbacComponent;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionSignIn()
    {
//        $this->enableCsrfValidation = false;
        $model = new User();

        if (\Yii::$app->request->isPost){
//            var_dump(\Yii::$app->request->isAjax);
//            var_dump(\Yii::$app->request->post());
            $model->load(\Yii::$app->request->post());
//            $model->attributes = \Yii::$app->request->post()['LoginForm'];
            $model->scenarioSignIn();
			// var_dump($model->scenario);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if (\Yii::$app->auth->signIn($model)){
                $user = \Yii::$app->auth->getUserByName($model->phone);
//                var_dump($user);
//                return $this->redirect(['/']);
//                return \Yii::$app->rbac->canAdmin();
                return JSON::encode
                ([
                    'status' => 'OK',
                    'token' => $user->token,
                    'msg' => 'Вы удачно вошли в систему',
                    'admin' => \Yii::$app->rbac->canAdmin(),
                ],JSON_FORCE_OBJECT);
            }else{
                return JSON::encode
                ([
                    'status' => 'deny',
                    'token' => '',
                    'msg' => $model->errors
                ],JSON_FORCE_OBJECT);
            }
        }

//        return $this->render('sign-in', ['model' => $model]);

    }
    public function actionSignUp(){

        $model = new User();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            $model->scenarioSignUp();
//            var_dump($model);
            if (\Yii::$app->auth->signUp($model)){
//              return $this->redirect(['auth/sign-in', 'id' => $model->id]);
                return Json::encode([
                    'status' => 'registered',
                    'token' => '',
                    'msg' => 'Вы удачно зарегистрировались'
                ],JSON_FORCE_OBJECT);
            }else{
//                var_dump($model->errors);exit();
                $phoneError = $model->errors['phone'][0] ?? '';
                return Json::encode([
                    'status' => 'rejected',
                    'error' =>  $model->errors
                ]);
            }
        }

//        return$this->render('sign-up', ['model' => $model]);
    }

}
