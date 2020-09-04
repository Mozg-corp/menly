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

/**
*
			basepath="/"
 *     @OA\Info(
			version="1.0", 
			title="menly.ru API",
),
 */
 
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
		 
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	public function actionAddadmin(){
		$admin = new User();
		$admin->phone = 79251234567;
		$admin->password = 'menly_4ever';
		$admin->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($admin->password);
        $admin->auth_key = \Yii::$app->getSecurity()->generateRandomString();
        $admin->token = \Yii::$app->getSecurity()->generateRandomString();

        if($admin->save()){
            // $role = \Yii::$app->authManager->getRole('admin');
            // \Yii::$app->authManager->assign($role, $admin->getId());
            return true;
        }else{
			print_r($admin->errors);
		}
	}
	public function actionAddposts(){
		for($i=1;$i<10;$i++){
			$post = new Post();
			$post->title = 'Заголовок '.$i;
			$post->preview = 'Какой-то текст '.$i;
			$post->body = 'Какой-то текст '.$i.' и его более длинное продолжение';
			$post->id_users = 1;
			$post->img = 'https://via.placeholder.com/400x200';
			$post->postedAt = (new \DateTime('01/07/2020'))->add(new \DateInterval( "P".$i."D" ))->format('Y-m-d H:i:s');
			
			if(!$post->save()){
				print_r($post->errors);
			}
			
		}
	}
	public function actionApi(){
		$openapi = \OpenApi\scan('../');
		header('Content-Type: application/x-yaml');
		echo $openapi->toYaml();
	}
}
