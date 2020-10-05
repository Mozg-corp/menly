<?php
///Код готов, но нуждаеться в чистке
///
///
///
///
namespace app\controllers;
use Yii;
use yii\helpers\Json;
use yii\web\Response;

class BalanceController extends \yii\web\Controller
{
//http://menly/json.json
public function actionGet(){
    $ArrayPayment = array();
    $ArrayRides = array();
    $ArrayTravel = array();
    //
    try {
        $ResponseUrl = Yii::$app->request->get();
        $ReportJson=file_get_contents('http://menly/json.json');  //Расположение JSON файла
        $AnswerJson=json_decode($ReportJson,true);
        $ArrayPayment = $AnswerJson['data']['payment_summary'];   // Массив эм остатка на счету??
        $ArrayRides = $AnswerJson['data']['rides'];               // Массив с водителями
        sort($ArrayRides);                                        // Соритируем массив
        ///////////////////////////////Пример добавления в массив//////////////////////////
        $ArrayTravel = [1 => "23432",2=>"5435"];
        $ArrayTravel[3] = "999";
        $ArrayTravel[4] = "534534";
        $ArrayTravel[5] = "00000100000";
        /////
        $ArrayTravel =  array();
        //var_dump($ArrayTravel);
        //die();
        ///////////////////////////////////////////////////////////////////////////////////


        foreach ($ArrayRides as $key => $value) {  /// Дебагинг
            echo '</br>';
            $ArrayTravel[$value['driver_id']] += $value['driver_order_balance']+$value['driver_tips']; // Добовляем в глобальную переменную значения как чаявых так и стоимость поездки
            echo '</br>';
            var_dump($value['driver_id']);
            echo '</br>';
            echo $value['driver_order_balance']+$value['driver_tips']; // Вывод суммы и чаявых так и стоимости поездки
            echo '</br>';

        }
        echo '---</br>---';
        var_dump($ArrayTravel);
        die();












        var_dump($ArrayRides);
        die();
         } catch (Exception $e) {
            echo 'Выброшено исключение в классе Balance функции actionGet: ', $e->getMessage();
            die();
        }
        return "This good!";
        // return $this->render('index');
}


}

