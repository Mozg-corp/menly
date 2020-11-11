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
		$driverAccounts = \app\models\DriverAccount::find()->agregatorsAccountsArray($id)->cache(3600*24*30)->all();
		$driverAccounts_key = array_map(function($account){
			return [
				$account['name'],
				$account['account'],
				$account['id_agregator']
			];
		}, $driverAccounts);
		if($driverAccounts){
			$client = $this->controller->client;
			$factory = $this->controller->factory;
			$cache = \Yii::$app->cache;
			$key = [
				'balances',
				$id,
				$driverAccounts_key
			];
			$balances = $cache->get($key);
			if($balances === false){
				$repository = new \app\repositories\DAOBalance($driverAccounts, $client, $factory);
				$repository->read();
				$balances = $repository->result;
				$cache->set($key, $balances, 180);
			}
			return $balances;
		}else{
			throw new \yii\web\NotFoundHttpException('Не найдены зарегистрированные аккаунты агрегаторов');
		}
	}
}