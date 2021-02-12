<?php namespace app\controllers\actions\useragregator;
class BatchAction extends \yii\rest\Action{
	public function run(){
		$relations = \Yii::$app->getRequest()->getBodyParams();
		$models = [];
		$user = \Yii::$app->user->identity;
		$userAgregators = $user->agregators;
		if(!count($userAgregators)){
			forEach($relations as $uaRelation){
				
					$model = new $this->controller->modelClass(); //можно просто $this->modelClass()
					$model->load($uaRelation, '');
					if(!$model->save()){
						return $model->errors;
					}
			}
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			$updated = \app\models\User::findOne($user->id); //Почему-то в сохранённой модели $model, не обновляется связь agregators и там не появляются сохранённые агрегаторы
			return $updated->agregators;
		}else{
			throw new \yii\web\BadRequestHttpException('relations already exists');
		}
		
	}
}