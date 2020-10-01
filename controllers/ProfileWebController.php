<?php

namespace app\controllers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Ramsey\Uuid\Uuid;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use app\models\Profile;


class ProfileWebController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;
	private $dispatcher;
	public function __construct($id, $module, \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher, $config=[]){
		$this->dispatcher = $dispatcher;
		parent::__construct($id,$module,$config);		
	}
    public function actionCreate()
    {
		$user_id = \Yii::$app->user->getId();		
		$form = new Profile();
		if(\Yii::$app->request->isPost){
			$model = \app\models\Profile::find()->where(['user_id' => $user_id])->one();
			$model = $model ? $model : new Profile();
			// $model->user_id = $user_id;
			$model->user_id = 1;
			$form->load(\Yii::$app->request->post());
			if($form->validate()){
				return $this->render('create', ['model' => $form]);
			}
			$model->fill($form);
			// var_dump(\Yii::$app->request->post());exit;
			if ($model->save()){
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				$model->id = \Yii::$app->db->getLastInsertID();
				// $notifier = \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
				// $notifier->sendProfileCreatedNotification($form);
				$this->dispatcher->dispatch(new \app\events\ProfileCreated($form));
				return $model;
			}else{
				// return print_r($model->errors);
				 return print_r(file_get_contents("php://input"));
			}
		}
		
		return $this->render('create', ['model' => $form]);
    }

}
