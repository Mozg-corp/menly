<?php namespace app\controllers;
use OpenApi as OA;
/**
* @OA\Get(
*	 path="/api/v1/users",
*    tags={"User"},
*    summary="Get all users.",
	security = {{"bearerAuth":{}}},
	 @OA\Response(
*         response = 200,
*         description = "List of Userss",
*         @OA\JsonContent(type="array", @OA\Items(ref = "#/components/schemas/UserResponse")),
*     )
),
*@OA\Get(
*	 path="/api/v1/users/{id}",
*    tags={"User"},
*    summary="Get single user.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single User",
*         @OA\JsonContent(ref = "#/components/schemas/UserResponse"),
*     ),
),
*@OA\Put(
*	 path="/api/v1/users/{id}",
*    tags={"User"},
*    summary="Change  user.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
*	 @OA\RequestBody(
*         description="User properties to be updated",
*         required=true,
		  @OA\JsonContent(ref="#/components/schemas/UserUpdate")
	 ),
*     @OA\Response(
*         response = 200,
*         description = "User Changed",
*         @OA\JsonContent(ref = "#/components/schemas/UserResponse"),
*     )
)
*/
class UserController extends \app\controllers\BaseController{
	public $modelClass = \app\models\User::class;
	public $updateScenario = \app\models\User::SCENARIO_UPDATE;
	public $createScenario = \app\models\User::SCENARIO_CREATE;


	public function checkAccess($action, $model = null, $params=[]){
		
			// print_r($action);
		if(\Yii::$app->rbac->canAdmin())return true;
		switch($action){
			case 'view': {
				if(\Yii::$app->user->id !== $model->id){
					throw new \yii\web\ForbiddenHttpException('You can see only your user data');
				}
				break;
			}
			default:	throw new \yii\web\ForbiddenHttpException('You can\'t work with this user data');
		}

		return true;
	}
}