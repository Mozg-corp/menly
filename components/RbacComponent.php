<?php


namespace app\components;

use app\models\GoodsLists;

class RbacComponent
{

    public function canAdmin(){
		$id = \Yii::$app->user->identity ? \Yii::$app->user->identity->id : null;
        if($id){
			foreach (\Yii::$app->authManager->getAssignments(\Yii::$app->user->identity->id) as $index => $assignment) {

//            var_dump($assignment);
            if ($assignment->roleName === 'admin') {

                return true;
            }
        }
		}
        return false;
    }
}