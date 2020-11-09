<?php namespace app\repositories;
abstract class DAOAgregators extends \yii\base\Model{
	protected $driverAccounts;
	protected $client;
	protected $factory;
	public $result;
	abstract protected function fetch():array;
	abstract protected function extractFromResponse($response, $name);
	abstract protected function getWithRefreshToken($name, $payload);
	public function __construct(array $driverAccounts, 
	  \app\interfaces\ClientInterface $client,
\app\interfaces\ServiceFactoryInterface $factory){
		$this->driverAccounts =  $driverAccounts;
		$this->client = $client;
		$this->factory = $factory;
		$this->result = [];
	} 
	private function send():array{
		$promises = $this->fetch();
		//settle не выдаёт ошибку на reject промиса
		$responses = \GuzzleHttp\Promise\settle($promises)->wait();
		return $responses;
	}
	public function read(){
		$responses = $this->send();
		forEach($this->driverAccounts as $account){
			$name = $account['name'];
			$driver_uid = $account['account'];
			$statePromise = $responses[$name]['state'];
			
			if($statePromise === 'fulfilled'){
				$this->result[$name] = $this->extractFromResponse($responses[$name], $name);
			}else if($statePromise === 'rejected'){
				$rawReasonBody = $responses[$name]['reason']->getResponse()->getBody()->getContents();
				$reasonBody = json_decode($rawReasonBody);
				if($reasonBody->code === 401 && $reasonBody->message === 'Expired JWT Token'){
					$this->result[$name] = $this->getWithRefreshToken($name, $payload);
				}else{
					throw new \GuzzleHttp\Exception\RequestException(\Psr7\Message::toString($responses[$name]['reason']->getResponse()));
				}
			}
		}
	}
}