<<<<<<< HEAD
<?php

namespace app\controllers;
use Yii;
use app\models\BalanceGet;
use app\models\BalanceYandex;
use app\models\BalanceCitymobil;
use yii\web\Controller;
use Guzzle\HttpClient\Client;

final class BalanceController extends \yii\web\Controller
{

public function actionGet(){
    try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceGet();
    $Balance->GetArray('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Get:', $e->getMessage();
      }
}

public function actionYandex(){
//// https://fleet-api.taxi.yandex.net


try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceYandex('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Yandex:', $e->getMessage();
      }

}
public function actionCitymobil(){
//// https://fleet.city-mobil.ru/api/doc
/// {type}/{version}/news
try{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $Balance = new BalanceCitymobil('http://menly/TEST.json');
    $balance = $Balance->GetArrayTravel();
    return $balance;
}catch(Exception $e) {
    echo 'Выброшено исключение в модели BalanceController функции Citymobil:', $e->getMessage();
      }

}
=======
<?php namespace app\controllers;
/**
*@OA\Get(
	path="/api/v1/balances/{id}",
	tags={"Balance"},
	summary="Get balances by user's agregators",
	security = {{"bearerAuth":{}}},
	@OA\Parameter(
		name="id",
		in="path",
		required=true
	),
	@OA\Response(
		response = 200,
		description="List of user's balances",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/BalanceResponse")
     *         )
	)
)
*/
class BalanceController extends BaseController{
	public $modelClass = \app\models\User::class;
	public $client;
	public $factory;
	public function __construct($id, $module, \app\interfaces\ClientInterface $client, \app\interfaces\ServiceFactoryInterface $factory, $config = []){
		$this->client = $client;
		$this->factory = $factory;
		parent::__construct($id, $module, $config);
	}
	
	public function actions(){
		return [
			'view' => [
				'class' => \app\controllers\actions\balance\ViewAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			]
		];
	}
	public function checkAccess($action, $model = null, $params=[]){
		if(\Yii::$app->rbac->canAdmin()) return true;
		switch($action){
			case 'view': {
				if(!\Yii::$app->user->can('viewOwnProfile', ['profile' => $model])){
					throw new \yii\web\ForbiddenHttpException('You can see only your own balance');
				}
				break;
			}
		}
	}
>>>>>>> 249e04144dfe1ddb1e84499b45b8ae3a90d30c29
}