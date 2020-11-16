<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfers".
 *
 * @property int $id
 * @property int $id_users
 * @property int $id_agregators
 * @property int $id_transfer_statuses
 * @property string|null $transfer
 * @property string|null $description
 * @property string|null $agregator_transfer_id
 * @property string|null $bank_transfer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Agregator $agregators
 * @property TransferStatus $transferStatuses
 * @property User $users
 */
class Transfer extends TransferBase
{
	public $agregatorName;
	const SCENARIO_DRIVER_TRANSFER = 'driver trasfer';
	const SCENRIO_ADMIN_TRANSFER = 'admin transfer';
	const SCENARIO_UPDATE = 'update transfer';
	const SCENARIO_CREATE = 'create transfer';
	public function fields(){
		return array_merge([
			'agregatorName',
		], parent::fields());
	}
	public function scenarios()
    {
        return array_merge([
           self::SCENARIO_DRIVER_TRANSFER => ['transfer', 'agregatorName'],
        ],parent::scenarios());
    }
    public function scenarioDriverTransfer():self
    {
        $this->setScenario(self::SCENARIO_DRIVER_TRANSFER);
        return $this;

    }
    public function scenarioAdminTransfer():self
    {
        $this->setScenario(self::SCENRIO_ADMIN_TRANSFER);
        return $this;
    }
	public function rules(){
		return array_merge([
			[['transfer'], 'transferValidator', 'on' => self::SCENARIO_DRIVER_TRANSFER],
			['agregatorName', 'required'],
			['agregatorName', 'agregatorNameChecker']
		], parent::rules());
	}
	public function transferValidator($transfer, $params){
		if((float) $this->transfer > 0){
			$this->addError($transfer, 'Списание должно быть отрицательным');
		}
	}
	public function agregatorNameChecker($name){
		$found = \app\models\Agregator::find()->getAgregatorByName($this->$name);
		
		if($found === null){
			$this->addError('agregatorName', 'Такого агрегатора нет');
			return;
		}
		//тут нужно реализовать ещё ситуацию, когда у пользователя нет такого агрегатора, а он пытается списать...
	}
    /**
     * {@inheritdoc}
     * @return TransferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransferQuery(get_called_class());
    }
}
