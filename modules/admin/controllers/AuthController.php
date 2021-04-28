<?php

namespace app\modules\admin\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\web\Response;
use app\components\RbacComponent;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = true;
    public $enableSession = true;
    public $layout = 'main-login';

    public function actionSignIn()
    {
        $model = new User();
        if (\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());

            $model->scenarioSignIn();
            //\Yii::$app->response->format = Response::FORMAT_JSON;

            if(\Yii::$app->auth->signIn($model)) {
                return $this->redirect('/admin/dashboard');
            }
        }
        return $this->render('sign-in', ['model' => $model]);
    }
    public function actionSignUp(){

        $model = new User();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            $model->scenarioSignUp();
            if (\Yii::$app->auth->signUp($model)){
				$user = \app\models\User::find()->where(['phone'=>$model->phone])->one();
				return [
					'success' => true,
					'user' => $user
				];
			}else{
				return [
					'success' => false,
					'errors' => $model->errors
				];
			}
        }
    }

}
