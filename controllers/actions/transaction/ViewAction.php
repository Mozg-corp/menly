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
		$driverAccounts= \app\models\DriverAccount::find()
										->where(['id_users' => $id])
										->select('name, account, id_agregator')
										->joinWith('agregator')
										->asArray()
										->all();
		// print_r($driverAccounts);die;						
		$promises = [];
		forEach($driverAccounts as $account){
			$name = $account['name'];
			// if($name === 'Ситимобиль'){
				$account = $account['account'];
				$payload = [];
				$payload['account'] = $account;
				// print_r($payload);die;
				$promises[$name] = $this->controller->client->getTransactionsByName($name, $payload);
			// }			
		}
		
		//*
		try{
			$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		}catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody()->getContents();
			$responseStdObj = json_decode($responseBodyAsString);
			print_r($responseStdObj);
			die;
		}
		$transaction = [];
		forEach($driverAccounts as $account){
			$name = $account['name'];
		// if($name!=='Яндекс')print_r($name);
			// if($name === 'Ситимобиль'){
				$staticService = $this->controller->factory->getClassByName($name);
				$statePromise = $responses[$name]['state'];
				//print_r($responses[$name]['reason']->getResponse()->getBody()->getContents());die;//['value']->getBody()->getContents());die;
				
				if($statePromise === 'fulfilled'){
					$response_transactions = $staticService::extractTransactionsFromResponse($responses[$name]);
					$transaction = array_merge($transaction, $response_transactions);
				}else if($statePromise === 'rejected'){
					$rawReasonBody = $responses[$name]['reason']->getResponse()->getBody()->getContents();
					$reasonBody = json_decode($rawReasonBody);
					//print_r($reasonBody);die;
					if($reasonBody->code === 401 && $reasonBody->message === 'Invalid JWT Token'){
						$agregator = \app\models\Agregator::find()->getAgregatorByName($name);
						$agregator->flushToken();
						$promise = $this->controller->client->getBalanceByName($name, $account);
						$response = $promise->wait();
						$body = $response->getBody()->getContents();
						$transaction[$name] = $staticService::extractBalanceFromBody(json_decode($body));
						//echo 'ta da!';

					}
				}
			// }
			// print_r($responses[$name]['reason']->getResponse()->getBody()->getContents());

			
		}
		uasort($transaction, function($left, $right){
			$prev = new \Datetime($left['date']);
			$next = new \Datetime($right['date']);
			if($prev == $next) return 0;
			return $prev < $next;
		});
		$dataProvider = new \yii\data\ArrayDataProvider([
			'allModels' => $transaction,
		]);
		return $dataProvider;
		//*/
	}
}