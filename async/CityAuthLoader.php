<?php namespace app\async; 
class CityAuthLoader extends \vxm\async\Task{
	public function run(){
		$authCitymobile = file_exists('../config/citymobile_auth_local.php')
		? (require '../config/citymobile_auth_local.php')
		: [];
		return $authCitymobile;
	}
}