<?php namespace app\commands;
class BalanceController extends \yii\console\Controller{
	private $client;
	public function __construct($id, $module, \app\interfaces\ClientInterface $client, $config=[]){
		parent::__construct($id, $module, $config);
		$this->client = $client;
	}
	
	public function actionGettReport(){
		$promise_create = null;
		$body_report = null;
		$date = new \DateTime();
		$date->add(new \DateInterval("PT3H"));
		$to = $date->format('Y-m-d H:i:s');
		$date->sub(new \DateInterval("P30D"));
		$from = $date->format('Y-m-d H:i:s');
		try{
			$promise_create =  $this->client->createGettReport($from, $to);
		}catch(\Exception $e){
			print_r($e);
			echo PHP_EOL;
		}
		if($promise_create){
			$response_create = $promise_create->wait();
			//print_r($response_create);
			echo PHP_EOL;
			$body_create = json_decode($response_create->getBody()->getContents());
			if($body_create->result === true){
				$uid = $body_create->uid;
				echo $uid .PHP_EOL;
				sleep(180);
				$promise_report = null;
				try{
					$promise_report = $this->client->readGettReport($uid);
				}catch(\Exception $e){
					print_r($e);
					echo PHP_EOL;
				}
				if($promise_report){
					$response_report = $promise_report->wait();
					$body_report = json_decode($response_report->getBody()->getContents());
					//print_r($body_report);
				}
			}else{
				print_r('bad create'.PHP_EOL .$body);
			}
			print_r($body_report);
		}
	}
	public function actionSeeReport(){
		$promise_report = null;
		try{
			$promise_report = $this->client->readGettReport("5f86eacdb4113");
		}catch(\Exception $e){
			print_r($e);
			echo PHP_EOL;
		}
		//print_r($promise_report);
		echo PHP_EOL;
		if($promise_report){
			$response_report = $promise_report->wait();
			$body_report= json_decode($response_report->getBody()->getContents());
			print_r($body_report->data->rides);
		}else{
			
		}
	}
}