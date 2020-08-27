<?php

namespace app\controllers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use Ramsey\Uuid\Uuid;

use app\models\Profile;


class ProfileWebController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new Profile();
		
		if(\Yii::$app->request->isPost){
			
			$model->file_foto_selfie = UploadedFile::getInstance($model, 'foto_selfie');
			$model->load(\Yii::$app->request->post());
			
			if($model->validate()){
				$uuid = Uuid::uuid4()->toString();
				$directory= 'profiles/' . $uuid;
				FileHelper::createDirectory($directory);
				$filename = $model->file_foto_selfie->baseName . '.' . $model->file_foto_selfie->extension;
				$model->file_foto_selfie->saveAs($directory . '/'. $filename);
				$model->uuid = $uuid;
				$model->foto_selfie = $directory . '/'. $filename;
				if ($model->save()){
					return \Yii::$app->db->getLastInsertID();
				}else{
					return $model->errors.toString();
				}
			}else{
				throw new \yii\web\HttpException(418, $model->errors);
			}
		}
		
		return $this->render('create', ['model' => $model]);
    }

}
