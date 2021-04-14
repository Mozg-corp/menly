<?php


namespace app\controllers;


use app\models\Subscription;
use yii\web\BadRequestHttpException;

class SubscriptionController extends BaseController
{
    public $modelClass = \app\models\Subscription::class;


    public function checkAccess($action, $model = null, $param = []){
        $postData = \Yii::$app->request->post();
        switch($action){
            case 'create':
                if(array_key_exists('id_users', \Yii::$app->request->post())){
                    if ($postData['id_users'] !==   \Yii::$app->user->id) {
                        throw new \yii\web\ForbiddenHttpException('You can create subscription only for yourself');
                    }
                }else{
                    throw new BadRequestHttpException('Check if request has id_users and id_tariffs field');
                }
                break;
            case 'view':
                if ($model->id_users !== \Yii::$app->user->id) {
                    throw new \yii\web\ForbiddenHttpException('You can view only yourself subscription');
                }
                break;
            default:
                if(!\Yii::$app->rbac->canAdmin()){
                    throw new \yii\web\ForbiddenHttpException('You cann\'t work with subscription data');
                }
        }
        return true;
    }
}
