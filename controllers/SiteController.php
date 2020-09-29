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
		$admin->phone = "79251234567";
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
	public function actionTest($id){
		//print_r(\Yii::$app->authManager->getPermissionsByUser(\Yii::$app->user->getId()));
		//\Yii::$app->user->loginByAccessToken('k2CPENB9Jv7NcvhvVC00Wp4SuvN0N7Lb');\app\models\Profile::findOne($id)]
		$profile = new \app\models\Profile();
		$profile->id =90;
        if(\Yii::$app->user->can('viewOwnProfile', [ 'profile' => $profile])){
			return 'ok';
		}else{
			return 'bad';
		}
	}
	public function actionAddPermission(){
		$am = \Yii::$app->authManager;
		
		$admin= $am->getRole('admin');
		
		$viewAllCars= $am->createPermission('updateAnyCar');
        $viewAllCars->description = 'Изменение любой машины';

        $am->add($viewAllCars);
		$am->addChild($admin, $viewAllCars);
	}
	public function actionSee(){

		$auth = file_exists('/'.@app.'/config/citymobile_auth_local.php')
			? (require '/'.@app.'/config/citymobile_auth_local.php')
			: [];
		$citymobile = \app\models\Agregator::find()->where(['name' => 'Ситимобиль'])->one();
		$client = new \yii\httpclient\Client(['baseUrl'=> $citymobile->apiv1]);
		$profile = \app\models\Profile::findOne(37);
		$registerer = new \app\services\CitymobileProfileRegister($profile, $auth, $client);
		$response = $registerer->register();
		// print_r(require '/'.@app.'/config/citymobile_auth_local.php');
		print_r($response);
	}
	public function actionGuzzle(){
		// $client = new \app\services\HttpClientService(['base_uri' => 'https://randomuser.me/api/']);
		$authCitymobile = file_exists('/'.@app.'/config/citymobile_auth_local.php')
			? (require '/'.@app.'/config/citymobile_auth_local.php')
			: [];
		$citymobile = new \app\services\CitymobileService($authCitymobile);
		$authGett = file_exists('/'.@app.'/config/gett_auth_local.php')
			? (require '/'.@app.'/config/gett_auth_local.php')
			: [];
		$gett = new \app\services\GettService($authGett);
		$client = new \app\services\HttpClientService(['citymobile' => $citymobile, 'gett' => $gett], ['headers' => [
																		'Content-Type' => 'application/json'
																		]
																	]);
		// $client = new \app\services\HttpClientService($citymobile);
		// $client = new \GuzzleHttp\Client();
		$responses = $client->loginAll();
		// return json_encode((new \app\services\CitymobileService())->loginRequest());
		return json_encode($responses);
	}
}
