<?php
namespace app\components;
use yii\base\Component;

class NotificationComponent extends Component{
	public $mailer;
	public function sendProfileCreatedNotification($profile){
		$respond = $this->mailer->compose('profile_created', ['profile' => $profile])
					->setSubject('New profile created')
					->setFrom('menly@iluka.ru')
					->setTo('voiptek@yandex.ru')
					->send();
	}
}