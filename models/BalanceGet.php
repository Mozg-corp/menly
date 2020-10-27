<?php

namespace app\models;

use Yii;
use yii\base\Model;

final class BalanceGet extends Model
{
private $ArrayRides = array();       // Массив с водителями
public $ArrayTravel = array();       // Массив с удачными путешествиями ([id = [Цена+чаевые]])
private $ArrayPayment = array();     // Массив по остатку платежей
<<<<<<< HEAD
public function GetArray($StringUrlContent){
=======
public function __construct($StringUrlContent){
>>>>>>> 249e04144dfe1ddb1e84499b45b8ae3a90d30c29
try {
        $ReportJson=file_get_contents($StringUrlContent);         //Расположение JSON файла
        $AnswerJson=json_decode($ReportJson,true);                // Получаем массив
        $ArrayPayment = $AnswerJson['data']['payment_summary'];   // Массив эм остатка на счету??
        $ArrayRides = $AnswerJson['data']['rides'];               // Массив с водителями
        sort($ArrayRides);                                        // Соритируем массив

        foreach ($ArrayRides as $key => $value) {

            $this->ArrayTravel[$value['driver_id']] += $value['driver_order_balance']+$value['driver_tips']; // Добовляем в глобальную переменную значения как чаявых так и стоимость поездки

        }

         } catch (Exception $e) {
            echo 'Выброшено исключение в модели BalanceGet функции Конструктор: ', $e->getMessage();
            die();
        }

return $this;
}
public function GetArrayTravel(){
    if(count($this->ArrayTravel)>0)
        { return $this->ArrayTravel;}
    else{
        echo 'Массив пустой';
    }
}

}
