<?php


namespace app\modules\admin\controllers\actions\dashboard;


use app\models\searchmodels\UserSearch;
use yii\base\Action;

class IndexAction extends Action
{
    public $modelClass = null;
    public $checkAccess = null;

    protected function run()
    {
        if($this->checkAccess){
            call_user_func($this->checkAccess, $this->id);
        }
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }
}
