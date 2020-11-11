<?php namespace app\controllers\actions\transaction;
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
		$driverAccounts= \app\models\DriverAccount::find()->agregatorsAccountsArray($id)->cache(3600*24*30)->all();
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
				'transactions',
				$id,
				$driverAccounts_key
			];
			$transactions = $cache->get($key);
			if($transactions === false){
				$repository = new \app\repositories\DAOTransactions($driverAccounts, $client, $factory);
				$repository->read();
				$sortedTransactions = $repository->sortedByDate;
				$transactions = $sortedTransactions;
				$cache->set($key, $sortedTransactions, 600);
			}			
			$dataProvider = new \yii\data\ArrayDataProvider([
				'allModels' => $transactions,
			]);
			return $dataProvider;
		}else{
			throw new \yii\web\NotFoundHttpException('Не найдены зарегистрированные аккаунты агрегаторов');
		}
	}
}