<?php namespace app\controllers\actions\useragregator;
class BatchAction extends \yii\rest\Action{
	public function run(){
        // if ($this->checkAccess) {
            // call_user_func($this->checkAccess, $this->id, $profile);
        // }
		// print_r(\Yii::$app->getRequest()->getBodyParams()); die;
		$relations = \Yii::$app->getRequest()->getBodyParams();
		$models = [];
		// return $this->modelClass();die;
		$user = \Yii::$app->user->identity;
		$userAgregators = $user->agregators;
		//return $userAgregators;die;
		if(!count($userAgregators)){
			forEach($relations as $uaRelation){
				
					$model = new $this->controller->modelClass();
					$model->load($uaRelation, '');
					//$model->scenarioBatchCreate();
					if(!$model->save()){
						return $model->errors;
					}
			}
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			$updated = \app\models\User::findOne($user->id);
			return $updated->agregators;
		}else{
			throw new \yii\web\BadRequestHttpException('relations already exists');
		}
		
	}
}