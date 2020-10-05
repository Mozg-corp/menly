<?php namespace app\services;
class ServiceFactory{
	public static function getServiceFactory( string $agregatorName){
		$agregatorApi = \app\models\Agregator::find()->getAgregatorByName($agregatorName);
		switch($agregatorName){
			case 'Ситимобиль': return new \app\services\CitymobileService(\Yii::$app->params['agregators']['citymobil']);
			case 'Gett': return new \app\services\GettService(\Yii::$app->params['agregators']['gett']);
		}
	}
}