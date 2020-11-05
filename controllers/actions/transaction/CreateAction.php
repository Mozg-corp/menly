<?php namespace app\controllers\actions\transaction;
class CreateAction extends \yii\rest\CreateAction{
	public function run(){
		$user = \Yii::$app->user->identity;
		// print_r($user);die;
		try{
			$profile = $user->profiles[0];
		}catch(\yii\base\ErrorException $e){
			throw new \yii\web\NotFoundHttpException('Заполните свой профиль');
		}
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $profile);
        }
		$createTransaction = new \app\models\CreateTransaction();
		$createTransaction->load(\Yii::$app->getRequest()->getBodyParams(), '');
		// $found = \app\models\Agregator::find()->getAgregatorByName($createTransaction->agregatorName);
		// print_r($createTransaction);die;
		
		
		if($createTransaction->validate()){
			$driverAccount = \app\models\DriverAccount::find()
														->where(['id_users' => $user->id])
														->select('name, account, id_agregator')
														->joinWith('agregator')
														->andWhere(['name' => $createTransaction->agregatorName])
														->asArray()
														->one();
			$name = $driverAccount['name'];
			$account = $driverAccount['account'];
			$payload = [];
			$payload['account'] = $account;
			$payload['balance'] = $createTransaction->balance;
			$promise = $this->controller->client->createTransactionByName($name, $payload);
			try{
				$response = $promise->wait();
				return [
					"code" => 200,
					"status" => 'OK',
					"message" => 'Успешно создана заявка на вывод средств.'
				];
			}catch(\GuzzleHttp\Exception\ClientException $e){
				$response = $e->getResponse();
				$responseBodyAsString = $response->getBody()->getContents();
				//$responseStdObj = json_decode($responseBodyAsString);
				return $responseBodyAsString;
			}
		}else{
			return $createTransaction->errors;
		}
		/*
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
					// if($name === 'Яндекс')$responses;die;
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