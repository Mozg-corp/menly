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
use app\models\Users;
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionIbuypro()
    {
        $graph = new Graph([
            1 => [[4, 50]],
            2 => [[3, 50], [7, 50]],
            3 => [[2, 50], [4, 50]],
            4 => [[1, 50], [3, 50],[5, 50],[9, 50]],
            5 => [[4, 50], [6, 50]],
            6 => [[5, 50], [11, 50]],
            7 => [[2, 50], [8, 50],[12, 50]],
            8 => [[7, 50], [9, 50]],
            9 => [[4, 50], [8, 50],[10, 50], [14, 50]],
            10 => [[9, 50], [11, 50]],
            11 => [[6, 50], [10, 50],[16, 50]],
            12 => [[7, 50], [13, 50]],
            13 => [[12, 50], [14, 50]],
            14 => [[9, 50], [13, 50],[15, 50]],
            15 => [[14, 50], [16, 50]],
            16 => [[11, 50], [15, 50]]
        ]);
        $solve = new IbuyproAlgorithm($graph, 13, [11,5]);
        $path = $solve->findPath();
//        foreach ($graph->getGraph() as $k => $v){
//            print_r($k ); echo '<br>';
//            foreach ($v as $item){
//                print_r($item );
//            }
//        }
//        exit;
        return $this->render('ibuypro', ['path'=>$path]);
    }

    public function actionCheck()
    {

        var_dump(\Yii::$app->user->getIdentity());
//        var_dump(\Yii::$app->rbac->canAdmin());
    }
	public function actionAddadmin(){
		$admin = new Users();
		$admin->username = 'admin';
		$admin->email = 'fake@mail.ru';
		$admin->password = 'domodel_4ever';
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
}
