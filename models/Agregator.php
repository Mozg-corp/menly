<?php

namespace app\models;
use Yii;

/**
*@OA\Schema(
	required={"name"},
 * @OA\Property(property="id", type="integer"),
 	 @OA\Property(property="name", type="string"),
	 @OA\Property(property="apiv1", type="string"),
	 @OA\Property(property="apiv2", type="string"),
	 @OA\Property(property="token", type="string"),
	 @OA\Property(property="expire", type="integer"),
	 @OA\Property(property="refresh_token", type="string")
)
 */

class Agregator extends AgregatorBase
{
	// const SCENARIO_UPDATE = 'update agregator';
	const SCENARIO_CREATE = 'create agregator';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
			[['name'], 'unique', 'on' => self::SCENARIO_CREATE],
			[['name'], 'required', 'on' => self::SCENARIO_CREATE]//,
			// [['name'], 'exist', 'on' => self::SCENARIO_UPDATE],
         ],parent::rules());
    }
	 /**
     * {@inheritdoc}
     * @return AgregatorBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgregatorQuery(get_called_class());
    }
	public function fields(){
		return [
			'id',
			'name',
			'apiv1',
			'apiv2'
		];
	}
}
