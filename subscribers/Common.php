<?php
namespace app\subscribers;
class Common implements \Symfony\Component\EventDispatcher\EventSubscriberInterface{
	public static function getSubscribedEvents(){
		return [
			\app\events\ProfileCreated::class => 'emailNotifyer'
		];
	}
	public function emailNotifyer(\app\events\ProfileCreated $event){
		//$notifier = \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
		//$notifier->sendProfileCreatedNotification($event);
	}

	public static function newProfileEmailNotifier($event){
		// $notifier = \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
		\Yii::$app->notifier->sendProfileCreatedNotification($event->sender);
	}

	public static function newCarEmailNotifier($event){
		// $notifier = \Yii::CreateObject(['class'=>\app\components\NotificationComponent::class, 'mailer' => \Yii::$app->mailer]);
		\Yii::$app->notifier->sendCarCreatedNotification($event->sender);
	}
	public static function updateUser($event){
		$transformStatusToRole = [
			\app\models\User::STATUS_CANDIDATE => 'candidate',
			\app\models\User::STATUS_USER => 'user'
		];
		if (isset($event->sender->status)) {
            $newTransformedStatus = $transformStatusToRole[$event->sender->status];

            $am = \Yii::$app->authManager;
            $am->revokeAll($event->sender->id);
            $newRole = $am->getRole($newTransformedStatus);
            $am->assign($newRole, $event->sender->id);
        }
	}
}
