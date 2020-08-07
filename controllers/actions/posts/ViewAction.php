<?php


namespace app\controllers\actions\posts;


use app\models\Post;
use yii\rest\Action;

class ViewAction extends Action
{
    public function run($id)
    {
//        if (\Yii::$app->rbac->canAdmin()) {
//            throw new \yii\web\ForbiddenHttpException(sprintf('Only administrators can edit maps.'));
//        }
        return Post::find()->andWhere(['id' => $id])->one();
    }
}