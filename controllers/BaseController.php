<?php

namespace app\controllers;

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
