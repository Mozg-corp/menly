<?php

namespace app\controllers\authenticators;

use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;

class MapsAuthenticator extends HttpBearerAuth
{
    public function beforeAction($action){

//        throw new    UnauthorizedHttpException();
        // if($action->id === 'index'){
            // return true;
        // }else{
            // try {
                // return parent::beforeAction($action);
            // } catch (UnauthorizedHttpException $e) {
                // throw $e;
            // }
        // }
            try {
                return parent::beforeAction($action);
            } catch (UnauthorizedHttpException $e) {
                throw $e;
            }
    }
}