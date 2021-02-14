<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\modules\admin\controllers\actions\dashboard\IndexAction;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DashboardController extends Controller
{
    public $enableCsrfValidation = true;
    public $enableSession = true;
    public $layout = 'main';
    //public $viewPath = '@app/moduls/admin/views';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actions()
    {
        return array_merge([
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => \Yii::$app->user->identity??new User(),
                'checkAccess' => [$this, 'checkAccess']
            ]
        ], parent::actions());
    }
    public function checkAccess($action, $model = null, $params=[]){

//        if(\Yii::$app->rbac->canAdmin())echo 'fffff';
//        else print_r(\Yii::$app->user);
        if(\Yii::$app->rbac->canAdmin())return true;
        else return $this->redirect('/admin/auth/sign-in');
//        switch($action){
//            case 'view':
//                if(!\Yii::$app->user->can('viewOwnProfile', [ 'profile' => $model])){
//                    throw new \yii\web\ForbiddenHttpException('It\'s not your profile');
//                }
//                break;
//
//            case 'index':
//                if(!\Yii::$app->user->can('viewAllProfiles')){
//                    throw new \yii\web\ForbiddenHttpException('You can see only your own profile');
//                }
//                break;
//            case 'create':
//                if(\Yii::$app->request->post()['user_id'] !== \Yii::$app->user->id){
//                    throw new \yii\web\ForbiddenHttpException('You can create profile only for youself');
//                }
//                break;
//            case 'update':
//                if(!\Yii::$app->user->can('updateProfiles')){
//                    throw new \yii\web\ForbiddenHttpException('You can\'t update profile');
//                }
//                break;
//            case 'delete':
//                throw new \yii\web\ForbiddenHttpException('Nobody can delete profile');
//                break;
//            default:
//                return false;
//        }
//        return true;
    }
}
