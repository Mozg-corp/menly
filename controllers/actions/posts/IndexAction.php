<?php


namespace app\controllers\actions\posts;


use app\models\Post;
use yii\rest\Action;

class IndexAction extends Action
{
    public function run()
    {
//        if (\Yii::$app->rbac->canAdmin()) {
//            throw new \yii\web\ForbiddenHttpException(sprintf('Only administrators can edit maps.'));
//        }
        return Post::find()->all();
    }
}