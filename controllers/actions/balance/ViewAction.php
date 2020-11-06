<?php namespace app\controllers\actions\balance;
class ViewAction extends \yii\rest\ViewAction{
	public function run($id){
		$user = $this->findModel($id);
		try{
			$profile = $user->profiles[0];
		}catch(\yii\base\ErrorException $e){
			throw new \yii\web\NotFoundHttpException('Заполните свой профиль');
		}
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $profile);
        }
		$driverAccounts= \app\models\DriverAccount::find()->agregatorsAccountsArray($id)->all();
		if($driverAccounts){
			$client = $this->controller->client;
			$factory = $this->controller->factory;
			$balance = new \app\models\Balance($driverAccounts, $client, $factory);
			$balance->requestBalances();
			return $balance;
		}else{
			throw new \yii\web\NotFoundHttpException('Не найдены зарегистрированные аккаунты агрегаторов');
		}
	}
}