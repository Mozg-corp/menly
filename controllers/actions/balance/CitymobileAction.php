<?php namespace app\controllers\actions\balance;
class CitymobileAction extends \yii\rest\Action{
	
	public function run(){
		if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null);
        }
		return $this->controller->client->getCityBalance("786565");
	}
}