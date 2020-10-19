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
}