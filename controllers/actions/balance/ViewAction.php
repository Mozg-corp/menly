<?php namespace app\controllers\actions\balance;
class ViewAction extends \yii\rest\ViewAction{
	public function run($id){
		$model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
		return $model->profiles[0]->id_yandex;
		//return $this->controller->client->getCityBalance("786565");
        //return $model;
	}
}