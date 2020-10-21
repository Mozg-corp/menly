<?php

namespace app\models;

use Yii;

class YandexDrivers extends \yii\db\ActiveRecord
{
public $id;
public $phone_number;
public $Name;
public $Car;
public $ArrayResponseDrivers;
public function GetArrayDrivers($StringUrlContent){
        $ReportJson=file_get_contents($StringUrlContent);         //Расположение JSON файла
        $AnswerJson=json_decode($ReportJson,true);
        $Array = array();
        foreach ($AnswerJson['driver_profiles']  as  $value) {
           $Array = $value;
           $this->ArrayResponseDrivers .= $value;

        }
        return $Array;
}

}
