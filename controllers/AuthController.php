<?php

namespace app\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\web\Response;
use app\components\RbacComponent;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
/**
* @OA\Post(
	path="/auth/sign-in",
	tags={"auth"},
	summary="User authentication",
	@OA\RequestBody(
		
		@OA\MediaType(
			mediaType="multipart/form-data",
*             @OA\Schema(
				type="object",
				@OA\Property(property="User[phone]", type="string"),
			  @OA\Property(property="User[password]", type="string"),
			  required={"User[phone]", "User[password]"}
			)
		)
	),
	@OA\Response(
		response=200,
		description="Successfull authentication",
		@OA\JsonContent(ref="#/components/schemas/UserResponse")
	)
),
* @OA\Post(
	path="/auth/sign-up",
	tags={"auth"},
	summary="User registration",
	@OA\RequestBody(
		
		@OA\MediaType(
			mediaType="multipart/form-data",
*             @OA\Schema(
				type="object",
				@OA\Property(property="User[phone]", type="string"),
				  @OA\Property(property="User[password]", type="string"),
				  @OA\Property(property="User[password_repeat]", type="string"),
				  required={"User[phone]", "User[password]", "User[password_repeat]"}
			)
		)
	),
	@OA\Response(
		response=200,
		description="Successfull registration",
		@OA\JsonContent(ref="#/components/schemas/UserResponse")
	)
)
*/
    public function actionSignIn()
    {
        $model = new User();
        if (\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
			
            $model->scenarioSignIn();
            \Yii::$app->response->format = Response::FORMAT_JSON;
			if(\Yii::$app->auth->signIn($model)){
				
				return [
					'success' => true,
					'user' => \Yii::$app->user->identity
				];
			}else{
				return [
					'success' => false,
					'errors' => $model->errors
				];
			}
        }
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
