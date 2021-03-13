<?php


namespace app\controllers;


class SubscriptionController extends BaseController
{
    public $modelClass = \app\models\Subscription::class;


    public function checkAccess($action, $model = null, $param = []){
        switch($action){
            case 'create':
                if(array_key_exists('id_users', \Yii::$app->request->post()) && \Yii::$app->request->post()['id_users'] !== \Yii::$app->user->id){
                    throw new \yii\web\ForbiddenHttpException('You can create subscription only for yourself');
                }else{
                    throw new \yii\web\BadRequestHttpException('wrong request body');
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
