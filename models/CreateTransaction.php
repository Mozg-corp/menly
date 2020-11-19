<?php namespace app\models;
class CreateTransaction extends \yii\base\Model{
	public $agregatorName;
	public $balance;
	public $id_user;
	
	public function rules(){
		return [
			['balance', 'string'],
			['id_user', integer],
			['agregatorName', 'agregatorNameChecker']
		];
	}
	public function agregatorNameChecker($name){
		$found = \app\models\Agregator::find()->getAgregatorByName($this->$name);
		
		if($found === null){
			$this->addError('agregatorName', 'Такого агрегатора нет');
			return;
		}
		//тут нужно реализовать ещё ситуацию, когда у пользователя нет такого агрегатора, а он пытается списать...
	}
}