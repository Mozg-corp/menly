<?php namespace app\controllers\actions\balance;
class ViewAction extends \yii\rest\ViewAction{
	public function run($id){
		$user = $this->findModel($id);
		try{
			$profile = $user->profiles[0];
		}catch(\yii\base\ErrorException $e){
			throw new \yii\web\NotFoundHttpException('Такой пользователь не найден');
		}
		// return $profile;
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $profile);
        }
		$driverAccounts= \app\models\DriverAccount::find()
										->where(['id_users' => $id])
										->select('name, account, id_agregator')
										->joinWith('agregator')
										->asArray()
										->all();
		// return $driverAccounts;
		$promises = [];		
		forEach($driverAccounts as $account){
			$name = $account['name'];
			$account = $account['account'];
			$promises[$name] = $this->controller->client->getBalanceByName($name, $account);			
		}
		$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		$balances = [];
		forEach($driverAccounts as $account){
			$name = $account['name'];
			$body = json_decode($responses[$name]['value']->getBody()->getContents());
			$staticService = $this->controller->factory->getClassByName($name);
			$balances[$name] = $staticService::extractBalanceFromBody($body);
		}
		return $balances;
	}
}