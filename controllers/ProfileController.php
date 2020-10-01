<?php
namespace app\controllers;
use OpenApi as OA;
define("API_HOST", (YII_ENV_DEV === "production") ? "example.com" : "localhost");
/**
*

* @OA\Get(
*	 path="/api/v1/profiles",
*    tags={"Profile"},
*    summary="Get all profiles.",
	 
		security = {{"bearerAuth":{}}},
	 
*     @OA\Response(
*         response = 200,
*         description = "List of Profiles",
*         @OA\JsonContent(type="array", @OA\Items(ref = "#/components/schemas/ProfileResponse")),
*     )
),* 
@OA\Get(
*	 path="/api/v1/profiles/{id}",
*    tags={"Profile"},
*    summary="Get single profile.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Profile",
*         @OA\JsonContent(ref = "#/components/schemas/ProfileResponse"),
*     ),
),* 
@OA\Post(
*	 path="/api/v1/profiles",
*    tags={"Profile"},
*    summary="Create new profile.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\RequestBody(
*         description="Profile object to be created",
*         required=true,
		  @OA\JsonContent(ref="#/components/schemas/Profile")
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Profile",
*         @OA\JsonContent(ref = "#/components/schemas/ProfileResponse"),
*     ),
*     @OA\Response(
*         response = 422,
*         description = "Data Validation Failed",
*         @OA\JsonContent(@OA\Items(
				@OA\Property(property="field", type="string"),
				@OA\Property(property="message", type="string")
			)),
*     ),
)
*/

class ProfileController extends \app\controllers\BaseController
{
	public $modelClass = \app\models\Profile::class;
	public $updateScenario = \app\models\Profile::SCENARIO_UPDATE;
	public $createScenario = \app\models\Profile::SCENARIO_CREATE;

	public function actionIndex(){
		return \Yii::$app->request;
	}
	public function checkAccess($action, $model = null, $params=[]){
		if(\Yii::$app->rbac->canAdmin())return true;
		switch($action){
			case 'view': 
				if(!\Yii::$app->user->can('viewOwnProfile', [ 'profile' => $model])){
					throw new \yii\web\ForbiddenHttpException('It\'s not your profile');
				}
				break;
			
			case 'index': 
				if(!\Yii::$app->user->can('viewAllProfiles')){
					throw new \yii\web\ForbiddenHttpException('You can see only your own profile');
				}
				break;
			case 'create':
				break;
			case 'update':
				if(!\Yii::$app->user->can('updateProfiles')){
					throw new \yii\web\ForbiddenHttpException('You can\'t update profile');
				}
				break;
			case 'delete':
				throw new \yii\web\ForbiddenHttpException('Nobody can delete profile');
				break;
			default: 
				return false;
		}
		return true;
	}
}
	
