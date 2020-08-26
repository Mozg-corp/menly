<?php

namespace app\controllers;
use app\models\Profile;

class ProfileWebController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new Profile();
		
		if(\Yii::$app->request->isPost){
			$model->load(\Yii::$app->request->post());
			
			// return $model;
		}
		
		return $this->render('create', ['model' => $model]);
    }

}
