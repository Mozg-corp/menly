<?php namespace app\async;
class FindCitymobileAgregator extends \vxm\async\Task{
	private $modelClass;
	public function run(){
		return $modelClass()::find();
	}
}