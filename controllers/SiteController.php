<?php

namespace app\controllers;

use app\lib\ibuypro\Graph;
use app\lib\ibuypro\IbuyproAlgorithm;
// use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\RbacComponent;
use app\models\Post;
use app\models\User;
use yii\base\Component;


class SiteController extends Controller
{
	private $client;
	public function __construct($id, $module, \app\interfaces\ClientInterface $client, $config=[]){
		$this->client = $client;
		parent::__construct($id, $module, $config);
	}

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'docs' => [
                'class' => 'app\controllers\actions\site\SwaggerUIRenderer',
                'restUrl' => \yii\helpers\Url::to(['site/json-schema']),
            ],
            'json-schema' => [
                'class' => 'app\controllers\actions\site\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    \Yii::getAlias('@app/controllers'),
                    \Yii::getAlias('@app/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	// public function actionAddadmin(){
		// $admin = new User();
		// $admin->phone = "79251234567";
		// $admin->password = 'menly_4ever';
		// $admin->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($admin->password);
        // $admin->auth_key = \Yii::$app->getSecurity()->generateRandomString();
        // $admin->token = \Yii::$app->getSecurity()->generateRandomString();

        // if($admin->save()){
            // return true;
        // }else{
			// print_r($admin->errors);
		// }
	// }
	public function actionChangeRole(){
		$transformStatusToRole = [
			\app\models\User::STATUS_CANDIDATE => 'candidate',
			\app\models\User::STATUS_USER => 'user'
		];
		$user = \app\models\User::findOne(33);
		$am = \Yii::$app->authManager;
		file_get_contents(@webroot.'/output.txt');
		// $oldRole = $am->getRole($transformStatusToRole[2]);
		// $am->revoke($oldRole, 33);
		/*
		$oldTransformedStatus = $transformStatusToRole[$event->sender->oldAttributes['status']]??null;
		$newTransformedStatus = $transformStatusToRole[$event->sender->status]??null;
		$am = \Yii::$app->authManager;
		if($oldTransformedStatus){
			$oldRole = $am->getRole($oldTransformedStatus);
			$am->revoke($oldRole, $event->sender->id);
		}
		if($newTransformedStatus){
			$newRole = $am->getRole($newTransformedStatus);
			$am->assign($newRole, $event->sender->id);
		}
		*/
	}
}
