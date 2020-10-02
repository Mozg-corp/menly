<?php namespace app\controllers;
/**
*

* @OA\Get(
*	 path="/api/v1/cars",
*    tags={"Car"},
*    summary="Get all cars.",
	 
		security = {{"bearerAuth":{}}},
	 
*     @OA\Response(
*         response = 200,
*         description = "List of Cars",
*         @OA\JsonContent(type="array", @OA\Items(ref = "#/components/schemas/Car")),
*     )
),
* 
@OA\Get(
*	 path="/api/v1/cars/{id}",
*    tags={"Car"},
*    summary="Get single car.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Car",
*         @OA\JsonContent(ref = "#/components/schemas/Car"),
*     ),
),
@OA\Post(
*	 path="/api/v1/cars",
*    tags={"Car"},
*    summary="Create new car.",
	 
		security = {{"bearerAuth":{}}},
	 @OA\RequestBody(
*         description="Car object to be created",
*         required=true,
		  @OA\JsonContent(ref="#/components/schemas/Car")
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Profile",
*         @OA\JsonContent(ref = "#/components/schemas/Car"),
*     ),
*     @OA\Response(
*         response = 422,
*         description = "Data Validation Failed",
*         @OA\JsonContent(@OA\Items(
				@OA\Property(property="field", type="string"),
				@OA\Property(property="message", type="string")
			)),
*     ),
*     @OA\Response(
*         response = 403,
*         description = "Forbidden",
*         @OA\JsonContent(@OA\Items(
				@OA\Property(property="name", type="string", example="Forbidden"),
				@OA\Property(property="message", type="string", example="You can create car only for you"),
				@OA\Property(property="code", type="integer"),
				@OA\Property(property="status", type="integer", example="403"),
				@OA\Property(property="type", type="string", example="yii\\web\\ForbiddenHttpException")
			)),
*     ),
),
@OA\Put(
*	 path="/api/v1/cars/{id}",
*    tags={"Car"},
*    summary="Update existing car.",
	 
		security = {{"bearerAuth":{}}},
	@OA\Parameter(
		name="id",
		in="path",
		required=true
	 ),
	 @OA\RequestBody(
*         description="Car properties to be updated",
*         required=true,
		  @OA\JsonContent(ref="#/components/schemas/CarUpdate")
	 ),
*     @OA\Response(
*         response = 200,
*         description = "Single Profile",
*         @OA\JsonContent(ref = "#/components/schemas/Car"),
*     ),
*     @OA\Response(
*         response = 422,
*         description = "Data Validation Failed",
*         @OA\JsonContent(@OA\Items(
				@OA\Property(property="field", type="string"),
				@OA\Property(property="message", type="string")
			)),
*     ),
*     @OA\Response(
*         response = 403,
*         description = "Forbidden",
*         @OA\JsonContent(@OA\Items(
				@OA\Property(property="name", type="string", example="Forbidden"),
				@OA\Property(property="message", type="string", example="You cann't update car"),
				@OA\Property(property="code", type="integer"),
				@OA\Property(property="status", type="integer", example="403"),
				@OA\Property(property="type", type="string", example="yii\\web\\ForbiddenHttpException")
			)),
*     ),
)
*/
class CarController extends \app\controllers\BaseController{
	public $modelClass = \app\models\Car::class;
	public $updateScenario = \app\models\Car::SCENARIO_UPDATE;
	public $createScenario = \app\models\Car::SCENARIO_CREATE;
	
	public function checkAccess($action, $model = null, $params = []){
		if(\Yii::$app->rbac->canAdmin())return true;
		switch($action){
			case 'index': 
				if(!\Yii::$app->user->can('viewAllCars')){
					throw new \yii\web\ForbiddenHttpException('You can see only your own car');
				}
				break;
			case 'view':
				if(!\Yii::$app->user->can('viewOwnCar', [ 'car' => $model])){
					throw new \yii\web\ForbiddenHttpException('It\'s not your car');
				}
				break;
			case 'create':
				if(\Yii::$app->request->post()['id_users'] !== \Yii::$app->user->id){
					throw new \yii\web\ForbiddenHttpException('You can create car only for youself');
				}
				break;
			case 'update':
				if(!\Yii::$app->user->can('updateAnyCar')){
					throw new \yii\web\ForbiddenHttpException('You cann\'t update car');
				}
				break;
		}
		return true;
	}
}