<?php namespace app\controllers\actions\transfer;
class BatchAction extends \yii\rest\Action{
	public function run(){
		$transfersData = \Yii::$app->getRequest()->getBodyParams();
		$user = \Yii::$app->user->identity;
		$transfers = [];
		// return gettype($transfersData[0]);
		foreach($transfersData as $transferData){
			$transfer = new \app\models\Transfer();
			$transfer->agregatorName = $transferData['agregatorName'];
			$transfer->transfer = $transferData['transfer'];
			$transfer->id_users = $user->id;
			$transfer->scenarioDriverTransfer();
			$driverAccount = \app\models\DriverAccount::find()
								->agregatorAccoutByName($transfer->id_users, $transfer->agregatorName)
								->one();
			$transfer->id_agregators = $driverAccount['id_agregator']??null;
			$transfer->description = "Создана заявка на вывод средтсв";
			if(!$transfer->validate()){
				return [
					'success' => false,
					$transfer->agregatorName => $transfer->errors
				];
			}else{
				$transfers[] = [
						$transfer->id_users,
						$transfer->id_agregators,
						$transfer->transfer,
						$transfer->description
				];
			}
		}
		// return $transfers;
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try{
			\Yii::$app->db->createCommand()
				->batchInsert('transfers', [
					'id_users',
					'id_agregators',
					'transfer',
					'description'
				], $transfers)->execute();
			$transaction->commit();
		}catch(\Throwable $e){
			$transaction->rollback();
			throw $e;
		}
		if(true){
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			return;
		}else{
			throw new \yii\web\BadRequestHttpException('');
		}
		
	}
}