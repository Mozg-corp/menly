<?php


namespace app\controllers;


use app\controllers\actions\posts\IndexAction;
use app\controllers\authenticators\MapsAuthenticator;
use app\models\Post;
use yii\base\InvalidConfigException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class PostsController extends ActiveController
{
    public $modelClass = Post::class;

    public function init()
    {
        try {
            parent::init();
        } catch (InvalidConfigException $e) {
        }
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->enableAutoLogin = false;

    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = MapsAuthenticator::className();
		 $behaviors['authenticator']['except'] = ['index', 'view'];
        return $behaviors;
    }

//    public function beforeAction($action)
//    {
//        return $action;
//    }

    public function actions(){
		
        return [
            'index' => [
                'class' => 'app\controllers\actions\posts\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
           'view' => [
               'class' => 'app\controllers\actions\posts\ViewAction',
               'modelClass' => $this->modelClass,
               'checkAccess' => [$this, 'checkAccess'],
           ],
            // 'create' => [
                // 'class' => 'app\controllers\actions\maps\CreateAction',
                // 'modelClass' => $this->modelClass,
                // 'checkAccess' => [$this, 'checkAccess'],
//                'scenario' => $this->createScenario,
            // ],
//            'update' => [
//                'class' => 'yii\rest\UpdateAction',
////                'modelClass' => $this->modelClass,
////                'checkAccess' => [$this, 'checkAccess'],
////                'scenario' => $this->updateScenario,
//            ],
//            'delete' => [
//                'class' => 'yii\rest\DeleteAction',
////                'modelClass' => $this->modelClass,
////                'checkAccess' => [$this, 'checkAccess'],
//            ],
////            'options' => [
////                'class' => 'yii\rest\OptionsAction',
////            ],
        ];
    }
}