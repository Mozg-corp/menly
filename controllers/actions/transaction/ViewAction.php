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
		$driverAccounts= \app\models\DriverAccount::find()->agregatorsAccountsArray($id)->all();
		if($driverAccounts){
			$client = $this->controller->client;
			$factory = $this->controller->factory;
			$transactions = new \app\repositories\DAOTransactions($driverAccounts, $client, $factory);
			$transactions->read();
			$result = $transactions->sortedByDate;
			
			$dataProvider = new \yii\data\ArrayDataProvider([
				'allModels' => $result,
			]);
			return $dataProvider;
		}else{
			throw new \yii\web\NotFoundHttpException('Не найдены зарегистрированные аккаунты агрегаторов');
		}
	}
}