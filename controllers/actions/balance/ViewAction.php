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
		$driverAccounts= \app\models\DriverAccount::find()
										->where(['id_users' => $id])
										->select('name, account, id_agregator')
										->joinWith('agregator')
										->asArray()
										->all();
										
		$promises = [];
		forEach($driverAccounts as $account){
			$name = $account['name'];
			$driver_uid = $account['account'];
			$promises[$name] = $this->controller->client->getBalanceByName($name, $driver_uid);			
		}
		try{
			$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		}catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody()->getContents();
			$responseStdObj = json_decode($responseBodyAsString);
			return $responseBodyAsString;
		}
		$balances = [];
		forEach($driverAccounts as $account){
			$name = $account['name'];
			$staticService = $this->controller->factory->getClassByName($name);
			$statePromise = $responses[$name]['state'];
			
			if($statePromise === 'fulfilled'){
				$balances[$name] = $staticService::extractBalanceFromResponse($responses[$name]);
			}else if($statePromise === 'rejected'){
				$rawReasonBody = $responses[$name]['reason']->getResponse()->getBody()->getContents();
				$reasonBody = json_decode($rawReasonBody);
				if($reasonBody->code === 401 && $reasonBody->message === 'Expired JWT Token'){
					$agregator = \app\models\Agregator::find()->getAgregatorByName($name);
					$agregator->flushToken();
					$driver_uid = $account['account'];
					$promise = $this->controller->client->getBalanceByName($name, $driver_uid);
					$response = $promise->wait();
					$body = $response->getBody()->getContents();
					$balances[$name] = $staticService::extractBalanceFromBody(json_decode($body));

				}
			}
			// print_r($responses[$name]['reason']->getResponse()->getBody()->getContents());

			
		}
		return $balances;
	}
}