<?php
namespace app\controllers;
/**
			basepath="/",
 *     @OA\Info(
			version="1.0", 
			title="menly.ru API",
		),

 @OA\SecurityScheme(
	bearerFormat="JWT",
	type="http",
	securityScheme="bearerAuth",
	scheme="bearer"
 )
*/
class BaseController extends \yii\rest\ActiveController
{
	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['authentication'] = [
			'class' => \yii\filters\auth\HttpBearerAuth::className(),
		];
		return $behaviors;
	}
}
