<?php


namespace app\modules\admin\controllers\actions\dashboard;


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
        return $this->controller->render('index', ['model' => $this->modelClass]);
    }
}