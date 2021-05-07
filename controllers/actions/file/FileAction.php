<?php


namespace app\controllers\actions\file;


class FileAction extends \yii\rest\Action
{
    public function run(){
        return [
            'Яндекс' => 554,
            'Ситимобиль' => 432,
            'Gett' => 542
        ];
    }
}