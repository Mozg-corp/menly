<?php namespace app\controllers;
use OpenApi as OA;
/**
*

* @OA\Get(
*	 path="/api/v1/agregators",
*    tags={"Agregator"},
*    summary="Get all agregators",
	 
		security = {{"bearerAuth":{}}},
	 
	 @OA\Parameter(
	  name="expand",
	  in="query"
	 ),
*     @OA\Response(
*         response = 200,
*         description = "List of all Agregators",
*         @OA\JsonContent(type="array", @OA\Items(ref = "#/components/schemas/AgregatorResponse")),
*     )
),
*@OA\Get(
*	 path="/api/v1/agregators/{id}",
*    tags={"Agregator"},
*    summary="Get single agregator.",
		security = {{"bearerAuth":{}}},
	 @OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
	 @OA\Parameter(
	  name="expand",
	  in="query"
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Agregator",
*         @OA\JsonContent(ref = "#/components/schemas/AgregatorResponse"),
*     ),
),
*@OA\Post(
	path="/api/v1/agregators",
	tags={"Agregator"},
	summary="Create new agregator",
	security = {{"bearerAuth":{}}},
	@OA\RequestBody(
		required=true,
		@OA\JsonContent(ref="#components/schemas/Agregator")
	),
	@OA\Response(
		response=200,
		description="Profile Created",
		@OA\JsonContent(ref="#/components/schemas/AgregatorResponse")
	)
),
*@OA\Put(
	path="/api/v1/agregators/{id}",
	tags={"Agregator"},
	summary="Update existing agregator",
	security={{"bearerAuth":{}}},
	@OA\Parameter(
		name="id",
		in="path",
		required=true
	),
	@OA\RequestBody(
		required=true,
		@OA\JsonContent(ref="#/components/schemas/AgregatorUpdate")
	),
	@OA\Response(
		response=200,
		description="Agregator updated",
		@OA\JsonContent(ref="#/components/schemas/AgregatorResponse")
	)
)
*/
class AgregatorController extends \app\controllers\BaseController{
	public $modelClass = \app\models\Agregator::class;
	// public $updateScenario = \app\models\Agregator::SCENARIO_UPDATE;
	public $createScenario = \app\models\Agregator::SCENARIO_CREATE;
	public function behaviors(){
        $behaviors = parent::behaviors();
		$behaviors['authentication']['except'] = ['index', 'view'];
        return $behaviors;
    }
	public function checkAccess($action, $model = null, $params = []){
		switch($action){
			case 'create':
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You can\'t create agregators');
				}
				break;
			case 'update':
				if(!\Yii::$app->rbac->canAdmin()){
					throw new \yii\web\ForbiddenHttpException('You can\'t change agregators');
				}
				break;
		}
		return true;
	}
}