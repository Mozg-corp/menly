<?php


namespace app\components;

use app\models\User;
use yii\base\Component;
use yii\web\IdentityInterface;

class AuthComponent extends Component
{
    /**
     * @param User $model
     * @return bool
     */
    public function signIn(IdentityInterface &$model)
    {
		if(!$model->validate(['phone', 'password'])){
            return false;
        }
        $user = $this->getUserByName($model->phone);
        if (!$this->validatePassword($model->password, $user->password_hash)){
            $model->addError('password', 'Wronge password');
            return false;
        }
		
        return \Yii::$app->user->login($user, 3600);
    }
    public function signUp(User &$model):bool
    {
        if(!$model->validate(['phone', 'password', 'password_repeat'])){
            return false;
        }

        $model->password_hash = $this->generateHashPassword($model->password);
        $model->auth_key = $this->generateAuthKey();
        $model->token = $this->generateToken();

        if($model->save()){
            $role = \Yii::$app->authManager->getRole('candidate');
            \Yii::$app->authManager->assign($role, $model->getId());
			echo '_____'.$model->phone.'____________';
            return true;
        }else{
			echo '========='.$model->phone.'==============';
			print_r($model->errors);
		}
        return false;
    }
    private function validatePassword($password, $passwordHash)
    {
        return \Yii::$app->security->validatePassword($password,$passwordHash);
    }
    public function getUserByName($phone):User
    {
		return User::find()->andWhere(['phone' => $phone])->one();
    }

    private function generateToken():string
    {
        return \Yii::$app->security->generateRandomString();
    }
    private function generateAuthKey():string
    {
        return \Yii::$app->security->generateRandomString();
    }

    private function generateHashPassword(string $password): string
    {
        return \Yii::$app->security->generatePasswordHash($password);
    }
}