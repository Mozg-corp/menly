<?php namespace app\controllers;
/**
*@OA\Get(
	path="/api/v1/user-agregator",
	tags={"user-agregator"},
	summary="Get all user-agregator relations",
	security={{"bearerAuth":{}}},
	@OA\Response(
		response=200,
		description="All user-agregator relations",
		@OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserAgregator"))
	)
),
*@OA\Get(
	path="/api/v1/user-agregator/{id}",
	tags={"user-agregator"},
	summary="Get single user-agregator relation",
	security={{"bearerAuth"={}}},
	@OA\Parameter(
		name="id",
		in="path",
		required=true
	),
	@OA\Response(
		response=200,
		description="Single user-agregator relation",
		@OA\JsonContent(ref="#/components/schemas/UserAgregator")
	)
)
*@OA\Post(
	path="/api/v1/user-agregator",
	tags={"user-agregator"},
	summary="Create new user-agregator relation",
	security={{"bearerAuth"={}}},
	@OA\RequestBody(
		required=true,
		@OA\JsonContent(ref="#/components/schemas/UserAgregator")
	),
	@OA\Response(
		response=200,
		description="New user-agregator relation've been created",
		@OA\JsonContent(ref="#/components/schemas/UserAgregator")
	)
)
*@OA\Put(
	path="/api/v1/user-agregator/{id}",
	tags={"user-agregator"},
	summary="Update existing user-agregator relation",
	security = {{"bearerAuth":{}}},
	@OA\Parameter(
		name="id",
		in="path",
		required=true
	),
	@OA\Response(
		response=200,
		description="user-agregator relation've been updated",
		@OA\JsonContent(ref="#/components/schemas/UserAgregator")
	)
),
*@OA\Post(
	path="/api/v1/user-agregator/batch",
	tags={"user-agregator"},
	summary="Batch creating user-agregator relation",
*	security = {{"bearerAuth":{}}},
	@OA\RequestBody(
		required=true,
		@OA\JsonContent(ref="#/components/schemas/UserAgregator")
	),
	@OA\Response(
		response=200,
		description="user-agregator relation've been updated",
		@OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserAgregator"))
	)
)
*/
class UserAgregatorController extends \app\controllers\BaseController{
	public $modelClass = \app\models\UserAgregator::class;
	
    
	public function actions(){
		return array_merge([
			'batch' => [
				'class' => \app\controllers\actions\useragregator\BatchAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			]
		], parent::actions());
	}
	public function checkAccess($action, $model = null, $param = []){
		switch($action){
			case 'create':
				if(array_key_exists('users_id', \Yii::$app->request->post()) && \Yii::$app->request->post()['users_id'] !== \Yii::$app->user->id){
					throw new \yii\web\ForbiddenHttpException('You can create user-agregator relation data only for yourself');
				}else{
					throw new \yii\web\BadRequestHttpException('wrong request body');
				}
				break;
			case 'batch':
				if(array_key_exists('users_id', \Yii::$app->request->post()) && \Yii::$app->request->post()['users_id'] !== \Yii::$app->user->id){
					throw new \yii\web\ForbiddenHttpException('You can create user-agregator relation data only for yourself');
				}else{
					throw new \yii\web\BadRequestHttpException('wrong request body');
				}
				break;
			default:
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You cann\'t work with this user-agregator relation data');
				}
		}
		return true;
	}
}