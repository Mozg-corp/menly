<?php
namespace app\bootstrap;
class EventsSubscriber implements \yii\base\BootstrapInterface{
	public function bootstrap($app){
		//$dispatcher = \Yii::$container->get(\Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class);
		//$dispatcher->addSubscriber(new \app\subscribers\Common());
		\yii\base\Event::on(\app\models\Profile::className(), \yii\db\ActiveRecord::EVENT_AFTER_INSERT, ['\app\subscribers\Common', 'newProfileEmailNotifier']);
		\yii\base\Event::on(\app\models\Car::className(), \yii\db\ActiveRecord::EVENT_AFTER_INSERT, ['\app\subscribers\Common', 'newCarEmailNotifier']);
		\yii\base\Event::on(\app\models\User::className(), \yii\db\ActiveRecord::EVENT_AFTER_UPDATE, ['\app\subscribers\Common', 'updateUser']);
	}
}