<?php namespace app\services;
class ServiceFactory implements \app\interfaces\ServiceFactoryInterface{
	public static function getServiceFactory( string $agregatorName){
		$agregatorApi = \app\models\Agregator::find()->getAgregatorByName($agregatorName);
		switch($agregatorName){
			case 'Ситимобиль': return new \app\services\CitymobileService(\Yii::$app->params['agregators']['citymobil']);
			case 'Gett': return new \app\services\GettService(\Yii::$app->params['agregators']['gett_ex_ex']);
			case 'Яндекс': return new \app\services\YandexService(\Yii::$app->params['agregators']['yandex']);
		}
	}
	public function getClassByName(string $agregatorName){
		switch($agregatorName){
			case 'Ситимобиль': return \app\services\CitymobileService::class;
			case 'Gett': return \app\services\GettService::class;
			case 'Яндекс': return \app\services\YandexService::class;
		}
	}
}