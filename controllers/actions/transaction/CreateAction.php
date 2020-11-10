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
		
		if($createTransaction->validate()){
			$driverAccount = \app\models\DriverAccount::find()
										->agregatorAccoutByName($user->id, $createTransaction->agregatorName)
										->all();
			$newTransaction = new \app\repositories\DAOTransactions($driverAccount);
			$newTransaction->create($createTransaction->balance);
			return $newTransaction;
		}else{
			return $createTransaction->errors;
		}
	}
}