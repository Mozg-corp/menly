<?php
namespace app\services;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Ramsey\Uuid\Uuid;

use app\interfaces\UpLoaderInterface;

class ProfileUpLoader implements UpLoaderInterface{
	
	
	// public function upload(\yii\base\Model &$model){
		// for($i=0; $i<count($model->fotos); $i++){
			// try{
				// if(property_exists($model, $model->fotos[$i])){
					// $model->{$model->fotos[$i]} = UploadedFile::getInstance($model, $model->forms[$i]);
				// }
			// }catch(Exeption $e){
				// continue;
			// }
			
		// }
		// return null;
	// }
	// public function load(\yii\base\Model &$model){
		// if($model->validate()){
			// $uuid = Uuid::uuid4()->toString();
			// $directory= 'profiles/' . $uuid;
			// FileHelper::createDirectory($directory);
			// for($i=0; $i<count($model->fotos); $i++){
				// try{
					// if($model->{$model->fotos[$i]}){
						// $filename = $model->{$model->fotos[$i]}->baseName . '.' . $model->{$model->fotos[$i]}->extension;
						// $model->{$model->fotos[$i]}->saveAs($directory . '/'. $filename);
						// $model->{$model->fotos[$i]} = $directory . '/'. $filename;
					// }
				// }catch(Exeption $e){
					// continue;
				// }
			// }
			// $model->uuid = $uuid;
		// }else{
			// return false;
		// }
		// return true;
	// }
}