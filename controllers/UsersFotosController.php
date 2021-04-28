<?php


namespace app\controllers;


use yii\rest\ActiveController;

class UsersFotosController extends ActiveController
{
    public $modelClass = \app\models\UsersFotos::class;
    public $updateScenario = \app\models\UsersFotos::SCENARIO_UPDATE;
    public $createScenario = \app\models\UsersFotos::SCENARIO_CREATE;

//    public function actions()
//    {
//        return [
//          'index' => [
//              'class' => FileAction::class,
//              'modelClass' => \app\models\UsersFotos::class
//          ]
//        ];
//    }

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
                //эту проверку надо бы заменить на rbac правило
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