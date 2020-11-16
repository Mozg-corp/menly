<?php namespace app\controllers\actions\transfer;
class CreateAction extends \yii\rest\CreateAction{
	public function run(){
		
		$transferNew = new \app\models\Transfer();
		$transferNew->load(\Yii::$app->getRequest()->getBodyParams(), '');
		$transferNew->scenarioDriverTransfer();
		$transferNew->id_users = \Yii::$app->user->id;
		$driverAccount = \app\models\DriverAccount::find()
										->agregatorAccoutByName($transferNew->id_users, $transferNew->agregatorName)
										->one();
									
		$transferNew->id_agregators = $driverAccount['id_agregator']??null;
		$transferNew->description = "Создана заявка на вывод средтсв";
		if(!$transferNew->save()&&!$transferNew->hasErrors()){
			throw new \yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
		}else{
			$response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($transferNew->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', \yii\helpers\Url::toRoute([$this->viewAction, 'id' => $id], true));
		}
		return;
	}
}