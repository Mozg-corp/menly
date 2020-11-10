<?php namespace app\commands;
class AddExistingUsersController extends \yii\console\Controller{
	public function actionAddUsers(){
		$initRepo = new \app\repositories\InitAgregatorsAlreadyExistsUsers();
		$initRepo->readJson([
			'Ситимобиль' => './raw/citymobile driver list.json',
			'Яндекс' => './raw/yandex drivers list.json',
			'Gett' => './raw/gett drivers list.json'
		]);
		$initRepo->saveUsersToDb();
		//print_r($initRepo->users);
	}
}