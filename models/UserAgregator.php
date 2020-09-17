<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_agregators".
 *
 * @property int $users_id
 * @property int $agregators_id
 * @property int $id
 *
 * @property Agregator $agregators
 * @property User $users
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
}
