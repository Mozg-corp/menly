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
            $model->load(\Yii::$app->request->post());
			
            $model->scenarioSignIn();
            \Yii::$app->response->format = Response::FORMAT_JSON;
            // if (\Yii::$app->auth->signIn($model)){
                // $user = \Yii::$app->auth->getUserByName($model->phone);
                // return JSON::encode
                // ([
                    // 'status' => 'OK',
                    // 'token' => $user->token,
                    // 'msg' => 'Вы удачно вошли в систему',
                    // 'admin' => \Yii::$app->rbac->canAdmin(),
                // ],JSON_FORCE_OBJECT);
            // }else{
                // return JSON::encode
                // ([
                    // 'status' => 'deny',
                    // 'token' => '',
                    // 'msg' => $model->errors
                // ],JSON_FORCE_OBJECT);
            // }
			if(\Yii::$app->auth->signIn($model)){
				
				return \Yii::$app->user->identity;
			}else{
				return $model->errors;
			}
        }

       //return $this->render('sign-in', ['model' => $model]);

    }
    public function actionSignUp(){

        $model = new User();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            $model->scenarioSignUp();
//            var_dump($model);
            //if (\Yii::$app->auth->signUp($model)){
//              return $this->redirect(['auth/sign-in', 'id' => $model->id]);
              //  return Json::encode([
                    // 'status' => 'registered',
                    // 'token' => '',
                    // 'msg' => 'Вы удачно зарегистрировались'
              //  ],JSON_FORCE_OBJECT);
            //}else{
//                var_dump($model->errors);exit();
                // $phoneError = $model->errors['phone'][0] ?? '';
             //   return Json::encode([
             //       'status' => 'rejected',
            //        'error' =>  $model->errors
             //   ]);
           // }
		   
            if (\Yii::$app->auth->signUp($model)){
				$user = \app\models\User::find()->where(['phone'=>$model->phone])->one();
				return $user;
			}else{
				return $model->errors;
			}
        }

//        return$this->render('sign-up', ['model' => $model]);
    }

}
