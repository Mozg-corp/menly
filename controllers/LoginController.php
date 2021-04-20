<?php


namespace app\controllers;


use app\models\User;
use yii\web\Response;

class LoginController extends \yii\web\Controller
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
    public function actionInit()
    {
        if( \Yii::$app->request->isPost ) {
            if( !isset( \Yii::$app->request->post()['phone'] )) {
                return [
                    'success' => false,
                    'errors' => [
                        'phone' => 'Поле телефон обязательно'
                    ]
                ];
            }
            $phone = \Yii::$app->request->post()['phone'];
            $lastRequesteTime = $this->session->get($phone . 'codeRequestTime');
            $now = time();
            if (true && $now - $lastRequesteTime > 90) {
                $this->session->set($phone . 'codeRequestTime', time());
                $codeStdObj = $this->requestCode();
                $this->session->set($phone . 'code', $codeStdObj->code);
                $codeRequestTime = $this->session->get($phone . 'codeRequestTime' );
                return [
                    'success' => true,
                    'requestTime' =>  $codeRequestTime,
                    'resubmitTime' => $codeRequestTime + 90,
                    'deadline' => $codeRequestTime + 60
                ];
            } else {
                $restTime = $lastRequesteTime + 90 - $now;
                return [
                    'success' => false,
                    'errors' => [
                        'toManyRequests' => "Сделайте запрос через $restTime сек."
                    ]
                ];
            }
        } else {
            return [
                'success' => false,
                'errors' => [
                    'wrongRequestType' => 'Запрос должен быть типа POST'
                ]
            ];
        }
    }

    public function actionAuth()
    {
        if(!\Yii::$app->request->isPost) {
            return [
                'success' => false,
                'errors' => [
                    'wrongRequestType' => 'Запрос должен быть типа POST'
                ]
            ];
        }
        if(!isset(\Yii::$app->request->post()['phone'])) {
            return [
                'success' => false,
                'errors' => [
                    'phone' => 'Поле телефон обязательно'
                ]
            ];
        }
        $phone = \Yii::$app->request->post()['phone'];
        if (!$this->session->has($phone . 'codeRequestTime') ) {
            return [
                'success' => false,
                'errors' => 'Нужно сперва запросить код'
            ];
        }
        if (!$this->session->has($phone . 'code')) {
            return [
                'success' => false,
                'errors' => 'Какая-то ошибка с получением code, попробуте повторно запросить код'
            ];
        }
        if (time() - $this->session->get($phone . 'codeRequestTime') > static::DURATION) {
            $this->session->remove($phone . 'code');
            $this->session->remove($phone . 'codeRequestTime');
            return [
                'success' => false,
                'errors' => [
                    'expire' => 'Время действия кода истекло'
                ]
            ];
        } else {
            if (!isset(\Yii::$app->request->post()['code'])) {
                return [
                    'success' => false,
                    'errors' => [
                        'code' => 'Отсутствует обязятельное поле code в запросе'
                    ]
                ];
            }
            $incomeCode = \Yii::$app->request->post()['code'];
            if ($incomeCode == $this->session->get($phone . 'code')) {
                $userFound = User::find()->byPhone($phone)->one();
                $this->session->remove($phone . 'code');
                $this->session->remove($phone . 'codeRequestTime');
                if ($userFound) {
                    return [
                        'success' => true,
                        'user' => $userFound
                    ];
                } else {
                    $model = new User();
                    $model->phone = \Yii::$app->request->post()['phone'];
                    $model->password = \Yii::$app->security->generateRandomString(8);
                    $model->password_repeat = $model->password;
                    $model->scenarioSignUp();
                    \Yii::$app->auth->signUp($model);
                    if (\Yii::$app->auth->signUp($model)) {
                        $user = \app\models\User::find()->where(['phone' => $model->phone])->one();
                        return [
                            'success' => true,
                            'user' => $user
                        ];
                    } else {
                        return [
                            'success' => false,
                            'errors' => $model->errors
                        ];
                    }
                }
            }
        }

    }

    public function requestCode()
    {
        return json_decode(json_encode([
            'code' => '0000'
        ]));
    }
}