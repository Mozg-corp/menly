<?php namespace app\bootstrap;
class DependencyInjector implements \yii\base\BootstrapInterface{
	public function bootstrap ($app){
		// \Yii::$container->set(\app\interfaces\ClientInterface::class, ['class' => '\app\services\HttpClientService']);
		// \Yii::$container->set(\app\services\LoginService::class, [], [\Yii::$container->get(\app\interfaces\ClientInterface::class)]);
		// \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
		//\Yii::$container->set(\app\services\LoginService::class, [], [\Yii::$container->get(\app\interfaces\ClientInterface::class)]);
	}
}