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

*     @OA\Response(
*         response = 200,
*         description = "Profile successfuly created/edited",
*         @OA\Schema(ref = "#components/schemas/Profile"),
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
	
