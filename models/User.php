<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**

 * @OA\Component(),
 * @OA\Schema(
	required={"phone", "password", "password_repeat"},
 * @OA\Property(property="User[phone]", type="string", example="7991234567"),
 * @OA\Property(property="User[password]", type="string"),
 * @OA\Property(property="User[password_repeat]", type="string"),
 * )
 */

class User extends UserBase implements IdentityInterface
{
     public $password;
	 public $password_repeat;
	 const STATUS_DELETED = 0;
	 const STATUS_ACTIVE = 10;
	 const STATUS_INACTIVE = 9;
	 const STATUS_CANDIDATE = 1;
	 const STATUS_USER = 2;

    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_SIGNIN = 'signin';
    const SCENARIO_UPDATE = 'update User';
    const SCENARIO_CREATE = 'create User';
	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['timestamp'] = [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ];
			return $behaviors;
	}
    public function scenarioSignUp():self
    {
        $this->setScenario(self::SCENARIO_SIGNUP);
        return $this;

    }
    public function scenarioSignIn():self
    {
        $this->setScenario(self::SCENARIO_SIGNIN);
        return $this;
    }

    public function scenarios()
    {
        return array_merge([
           self::SCENARIO_SIGNUP => ['phone','password', 'password_repeat'],
           self::SCENARIO_SIGNIN => ['phone', 'password'],
		   self::SCENARIO_UPDATE => ['status'],
		   self::SCENARIO_CREATE => [],
        ],parent::scenarios());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
		$rules = parent::rules();
		for($i=0;$i<count($rules);$i++){
			if($rules[$i][0][0] === 'phone' && $rules[$i][1] === 'unique'){
				unset($rules[$i]);
				break;
			}
		}
        return array_merge([
            ['password', 'required', 'on' => [self::SCENARIO_SIGNUP, self::SCENARIO_SIGNIN]],
            ['password_repeat', 'required', 'on' => [self::SCENARIO_SIGNUP]],
            ['password', 'string', 'min' => 8],
			['status', 'safe'],
			['password_repeat', 'compare', 'compareAttribute' => 'password'],
			['phone', 'match', 'pattern' => '/^[8,7]\d{3}\d{3}\d{2}\d{2}/', 'message' => 'Телефон, должен быть в формате 8XXXXXXXXXX или 7XXXXXXXXXX'],
            [['phone'], 'unique', 'on' => self::SCENARIO_SIGNUP],
            [['phone'], 'exist', 'on' => self::SCENARIO_SIGNIN],
         ],$rules);
    }
	public function fields(){
		return [
			'id',
			'phone',
			'token',
			'status',
			'create_at',
			'permissions' => function(){
				$p = \Yii::$app->authManager->getPermissionsByUser($this->id);
				return array_keys($p);
			},
			'roles' => function(){
				$r = \Yii::$app->authManager->getRolesByUser($this->id);
				return array_keys($r);
			},
			'car',
			'profile',
			'agregators'
		];
	}
	public function  extraFields(){
		return [
		
		];
	}
	
    /**
     * Gets query for [[Cars]].
     *
     * @return \yii\db\ActiveQuery|CarQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id_users' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery|ProfileQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersAgregators]].
     *
     * @return \yii\db\ActiveQuery|UsersAgregatorQuery
     */
    public function getUsersAgregators()
    {
        return $this->hasMany(UserAgregator::className(), ['users_id' => 'id']);
    }
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
       return User::find()->andWhere(['id' => $id])->one();
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['token' => $token])->one();
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
	public function getAgregators(){
		return $this->hasMany(\app\models\Agregator::className(),['id' => 'agregators_id'])
					->via('usersAgregators');
	}
	public function getAgregatorsNames(){
		return array_map(function($el){return $el->name;},$this->agregators);
	}
	/**
     * {@inheritdoc}
     * @return UserBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
