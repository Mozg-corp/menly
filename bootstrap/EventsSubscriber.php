<?php
namespace app\bootstrap;
class EventsSubscriber implements \yii\base\BootstrapInterface{
	public function bootstrap($app){
		$dispatcher = \Yii::$container->get(\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class);
		$dispatcher->addSubscriber(new \app\subscribers\Common());
	}
}