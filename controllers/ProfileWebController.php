<?php

namespace app\controllers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Ramsey\Uuid\Uuid;

use app\models\Profile;
use app\interfaces\UpLoaderInterface;


class ProfileWebController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;
	private $loader;
	public function __construct($id, $module, UpLoaderInterface $loader, $config=[]){
		$this->loader = $loader;
		parent::__construct($id,$module,$config);		
	}
	
    public function actionCreate()
    {
		$user_id = \Yii::$app->user->getId();		
		$model = \app\models\Profile::find()->where(['user_id' => $user_id])->one();
		if(\Yii::$app->request->isPost){
			$model->user_id = $user_id;
			$form = new Profile();
			$form->load(\Yii::$app->request->post());
			$model->fill($form);
			if ($model->save()){
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				$model->id = \Yii::$app->db->getLastInsertID();
				return $model;
			}else{
				return $model->errors.toString();
			}
		}
		
		return $this->render('create', ['model' => $model]);
    }

}
