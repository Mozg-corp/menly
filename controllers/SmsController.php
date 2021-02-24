<?php


namespace app\controllers;


use app\models\User;
use yii\web\Controller;
use yii\web\Response;

class SmsController extends Controller
{
    private const DURATION = 30;
    private $session = null;

    /**
     * SmsController constructor.
     * @inheritdoc
     */
    public function __construct( $id, $module, $config = [] )
    {
        $this->session = \Yii::$app->session;
        \Yii::$app->response->format = Response::FORMAT_JSON;

        parent::__construct( $id, $module, $config );
    }


    public function actionLogin()
    {
        if ( !$this->session->has('codeRequestTime') ) {
            return json_encode([
                'success' => false,
                'errors' => 'Нужно сперва запросить код'
            ]);
        }
        if ( !$this->session->has( 'code' )) {
            return json_encode([
                'success' => false,
                'errors' => 'Какая-то ошибка с получением code, попробуте повторно запросить код'
            ]);
        }
        if (!$this->session->has( 'phone' )) {
            return json_encode([
                'success' => false,
                'errors' => 'Какая-то ошибка с получением phone, попробуте повторно запросить код'
            ]);
        }
        if ( \Yii::$app->request->isPost ) {
            if ( time() - $this->session->get( 'codeRequestTime' ) > static::DURATION ) {
                $this->session->remove('code');
                $this->session->remove('codeRequestTime');
                $this->session->remove('phone');
                return [
                   'success' => false,
                   'errors' => [
                       'expire' => 'Время действия кода истекло'
                   ]
                ];
            }else {
                if ( !isset(\Yii::$app->request->post()['code'])) {
                    return json_encode([
                        'success' => false,
                        'errors' => [
                            'code' =>'Отсутствует обязятельное поле code в запросе'
                        ]
                    ]);
                }
                $incomeCode = \Yii::$app->request->post()['code'];
                if ( $incomeCode == $this->session->get('code')) {
                    $userFound = User::find()->byPhone($this->session->get( 'phone' ))->one();
                    if ($userFound) {
                        return [
                            'success' => true,
                            'user' => $userFound
                        ];
                    } else {
                        $model = new User();
                        $model->phone = $this->session->get('phone');
                        $model->password = \Yii::$app->security->generateRandomString(8);
                        $model->password_repeat = $model->password;
                        $model->scenarioSignUp();
                        \Yii::$app->auth->signUp($model);
                        if (\Yii::$app->auth->signUp($model)){
                            $user = \app\models\User::find()->where(['phone'=>$model->phone])->one();
                            return [
                                'success' => true,
                                'user' => $user
                            ];
                        }else{
                            return [
                                'success' => false,
                                'errors' => $model->errors
                            ];
                        }
                    }
                    $this->session->remove('code');
                    $this->session->remove('codeRequestTime');
                    $this->session->remove('phone');
                }
            }
        }

    }

    public  function actionInit()
    {
        if( \Yii::$app->request->isPost ) {
            if( !isset( \Yii::$app->request->post()['phone'] )) {
                return json_encode([
                    'success' => false,
                    'errors' => [
                        'phone' => 'Поле телефон обязательно'
                    ]
                ]);
            }
            $this->session->set('codeRequestTime', time());
            $codeStdObj = $this->requestCode();
            $this->session->set('code', $codeStdObj->code);
            $this->session->set('phone', \Yii::$app->request->post()['phone']);
//            \Yii::$app->response->format = Response::FORMAT_JSON;
//            \Yii::$app->response->statusCode = 200;
            return json_encode([
                'success' => true,
                'codeRequestTime' =>  $this->session->get( 'codeRequestTime' ),
            ]);
        }
    }

    public function requestCode()
    {
        return json_decode(json_encode([
           'code' => '0000'
        ]));
    }
}