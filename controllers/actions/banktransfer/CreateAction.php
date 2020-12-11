<?php namespace app\controllers\actions\banktransfer;
class CreateAction extends \yii\rest\Action{
	public function run(){
		$id = \Yii::$app->getRequest()->getBodyParams()['transfer_id']??null;
		$transfer = $this->modelClass::findOne($id);
		 if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
		if(!$transfer){
			throw new \yii\NotFoundHttpException('Такой перевод не найден');
		}
		$transferStatuse = \app\models\TransferStatus::find()->byStatus('Переведено')->one();
		$transfer->id_transfer_statuses = $transferStatuse->id;
		$transfer->description = 'Перевод осуществлён';
		if(!$transfer->save()&&!$transfer->hasErrors()){
			throw new \yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
		}else{
			$response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
		}
		return;
	}
}