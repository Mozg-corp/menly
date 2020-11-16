<?php namespace app\controllers\actions\transfer;
class AllOwnTransfersAction extends \yii\rest\Action{
	public function run(){
		$user = \Yii::$app->user->identity;
		$transfers = $this->modelClass::find()->byUserId($user->id);
		$dataprovider = new \yii\data\ActiveDataProvider([
			'query' => $transfers,
			'sort' => [
				'defaultOrder' => ['created_at' => SORT_DESC]
			]
		]);
		return $dataprovider;
	}
}