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
