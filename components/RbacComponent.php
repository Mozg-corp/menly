<?php


namespace app\components;

use app\models\GoodsLists;

class RbacComponent
{
    // public function canCreateGoodsList():bool{

        // return \Yii::$app->user->can('createGoodsList');
    // }
    // public function canChangeGoodsList(GoodsLists $goodsList){

        // if(\Yii::$app->user->can('viewOwnerGoodsList', ['goodslist' => $goodsList])){

            // return true;
        // }
        // return false;
    // }
    public function canAdmin(){

        foreach (\Yii::$app->authManager->getAssignments(\Yii::$app->user->getIdentity()->id) as $index => $assignment) {

//            var_dump($assignment);
            if ($assignment->roleName === 'admin') {

                return true;
            }
        }
        return false;
    }
}