<?php


namespace app\controllers;


use yii\rest\Controller;

class TariffController extends BaseController
{
    public $modelClass = \app\models\Tariff::class;
    // public $updateScenario = \app\models\Tariff::SCENARIO_UPDATE;
    public $createScenario = \app\models\Tariff::SCENARIO_CREATE;
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authentication']['except'] = ['index', 'view'];
        return $behaviors;
    }
    public function checkAccess($action, $model = null, $params = []){
        switch($action){
            case 'create':
                if(!\Yii::$app->rbac->canAdmin()){
                    throw new \yii\web\ForbiddenHttpException('You can\'t create tariffs');
                }
                break;
            case 'update':
                if(!\Yii::$app->rbac->canAdmin()){
                    throw new \yii\web\ForbiddenHttpException('You can\'t change tariffs');
                }
                break;
        }
        return true;
    }
}