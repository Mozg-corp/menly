<?php

namespace app\models;

use Yii;

/**
 * @OA\Schema(
	required={"agregators_id", "users_id"},
	@OA\Property(property="id", type="integer"),
	@OA\Property(property="agregators_id", type="integer"),
	@OA\Property(property="users_id", type="integer")
 
 )
 */
class UserAgregator extends \app\models\UserAgregatorBase
{
	const SCENARIO_UPDATE = 'update user agregator relation';
	const SCENARIO_CREATE = 'create user agregator relation';
	const SCENARIO_BATCH_CREATE = 'create User'; //Это надо заменить на "batch creation of user-agregator relations"
	
	public function scenarioBatchCreate():self
    {
        $this->setScenario(self::SCENARIO_BATCH_CREATE);
        return $this;
    }
	public function scenarios()
    {
        return array_merge([
		   self::SCENARIO_BATCH_CREATE => ['agregators_id'],
        ],parent::scenarios());
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
		
        ], parent::rules());
    }
	// public function fields(){
		// return [
			// 'agregators' => function(){
				
			// }
		// ];
	// }
}
