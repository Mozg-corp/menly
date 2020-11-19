<?php namespace app\controllers\actions\transaction;
class CreateAction extends \yii\rest\CreateAction{
	public function run(){
		if($this->checkAccess){
			call_user_func($this->checkAccess, $this->id);
		}
		$id = \Yii::$app->request->post()['transfer_id'];
		$client = $this->controller->client;
		$factory = $this->controller->factory;
		//здесь нужна проверка, что трансфер найден!
		$transfer = \app\models\Transfer::findOne($id);
		$transferCreatedStatus = \app\models\TransferStatus::find()->byStatus('Создан')->one();
		if($transfer->id_transfer_statuses !== $transferCreatedStatus->id){
			throw new \yii\web\BadRequestHttpException('Эта заявка уже выполнена или отменена', 400);
		}
		$id_agregators = $transfer->id_agregators;
		$agregator = \app\models\Agregator::findOne($id_agregators);
		$id_users = $transfer->id_users;
		$agregatorName = $agregator->name;
		$balance = $transfer->transfer;
		$driverAccounts = \app\models\DriverAccount::find()->agregatorAccoutByName($id_users, $agregatorName)->all();
		$transactionRepository = new \app\repositories\DAOTransactions($driverAccounts, $client, $factory);
		try{
			$transactionRepository->create($balance);
			$result = $transactionRepository->result;
			$transferStatus = \app\models\TransferStatus::find()->byStatus('Списано')->one();
			$transfer->id_transfer_statuses = $transferStatus->id;
			$transfer->description = 'Средства списаны со счёта агрегатора';
			$transfer->agregator_transfer_id = (string) $result;
			if(!$transfer->save()){
				return $transfer;
				//throw new \yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
			}else{
				$response = \Yii::$app->getResponse();
				$response->setStatusCode(201);
				$id = implode(',', array_values($transfer->getPrimaryKey(true)));
				$response->getHeaders()->set('Location', \yii\helpers\Url::toRoute([$this->viewAction, 'id' => $id], true));
				return [	
					'id' => $transfer->id,
					'agregator_transfer_id' => $transfer->agregator_transfer_id,
					'description' => $transfer->description
				];
			}
			
		}catch(\Trowable $e){
			//print_r('fdds');
			return $e;
		}
	}
}