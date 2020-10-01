<?php namespace app\async; 
class GettAuthLoader extends \vxm\async\Task{
	public function run(){
		$authGett = file_exists('../config/gett_auth_local.php')
		? (require '../config/gett_auth_local.php')
		: [];
		return $authGett;
	}
}