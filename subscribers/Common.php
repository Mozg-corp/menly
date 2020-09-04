<?php 
namespace app\subscribers; 
class Common implements \Symfony\Component\EventDispatcher\EventSubscriberInterface{
	public static function getSubscribedEvents(){
		return [
			\app\events\ProfileCreated::class => 'emailNotifyer'
		];
	}
	public function emailNotifyer(\app\events\ProfileCreated $event){
		$notifier = \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
		$notifier->sendProfileCreatedNotification($event);
	}
}