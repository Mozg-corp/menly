<?php namespace app\events; 

class ProfileCreated extends \Symfony\Contracts\EventDispatcher\Event{
	private $profile;
	public function __construct(\app\models\Profile $profile){
		$this->profile = $profile;
	}
	public function getProfile():\app\models\Profile{
		return $this->profile;
	}
}