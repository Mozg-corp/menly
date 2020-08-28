<?php
namespace app\components;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class LoggerComponent{
	public $logger;
	public function __construct(){
		$this->logger = new Logger('application');
		$this->logger->pushHandler(new StreamHandler('@app/log/application.log', Logger::DEBUG));
	}
	public function debug(string $msg){
		$this->logger->debug($msg);
	}
}