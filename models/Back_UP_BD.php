<?php
 /*// Был написан только для Бекапа БД
   // Для других задач не использовать
 */// Я серьёзно!!!
namespace app\models;

use Yii;
use yii\base\Model;

final class Back_UP_BD extends Model
{
    private $ArrayIN = Array();   // Входной массив [0=>[Массив 1го агригата],1=[Массив второго агрегата]] 0,1 ключ от количества огригаторов
    private $AnswerModel;
    private $KeyReady = FALSE;    // Пока не тру, массив не готов к выгрузке
    private $BdInfo;
    private $ArrayIN_info;        // Информация об массиве
    public  function setArryIN($Var){
        $this->ArrayIN = $Var;
        return $this;
    }
    public function CheckReady(){
        /////////// Проверка инфы от бд, вдруг она такое не подерживает
        try {
           $this->BdInfo = Yii::$app->db->createCommand("select version()")->execute();
        } catch (Exception $e) {
           $this->BdInfo = "Ошибка получения конфигариционной информации";
        }
        ///////////
        /////////// Проверка массива на валидность сложность o*n так как идём по массиву с начала до конца.
        /////////// Пропуская вложенность, проверя только то что он есть, не более
        /////////// Но тут проверяеться по колчисетсву агрегаторов.
        /////////// Не думаю что будем парсить около милионо кампаний, хотя......
        try {
           foreach ($this->ArrayIN as $key => $value) {

                if ($value) {
                    // Если код не сломался тут то массив есть
                }else{
                    $this->ArrayIN_info = 'Проверку на "if($value)" не прошла ';
                }
                if (empty($value)) {
                    // Если код не сломался тут то массив есть
                }else{
                    $this->ArrayIN_info = 'Проверку на "if(empty($value))" не прошла ';
                }
                if (count($value)) {
                    // Если код не сломался тут то массив есть

                }else{
                    $this->ArrayIN_info = 'Проверку на "if(count($value))" не прошла ';
                }
                ///Тут можно сделать проверку на адекватность полей.
                ///Но пока просто дедосим ключ



                /*
                Может тут проверить на валидацию?
                Таким методом
                foreach($value as $localvalue){
                    empty($localvalue['phone']);
                    empty($localvalue['name']);
                    empty($localvalue['car'])
                    и т.д.....
                    Хотя цикл в цикле я не знаю...
                    И тут можно повернуть ключ, в случае успеха...
                    $this->KeyReady = TRUE;
                    Хотя возможно сам по мебе дедошу переменную, не поломает ли это систему?
                    Как думаешь?

                }

                */
                $this->KeyReady = TRUE;
                /// В случае успешного прохода Тру должен остаться
           }

        } catch (Exception $e) {
            $this->ArrayIN_info = 'Ошибка в проверки валидации массива';
            $this->KeyReady = FALSE;

        }


    }
    //////////Функция по подготовки массива
    public function AddArray($NewArr){
            $counter = count($this->ArrayIN);      // Узнаём количество агрегаторов уже с готовым массивом
            $this->ArrayIN[$counter] = $NewArr;    // Добовляем по ключу агрегаторы массивов, с индекса 0
            return $this;
    }
    public function StartTransactionTo($ArrayStringNameTable){
        if($this->KeyReady == TRUE){  // Если ключ готов ,начинаем рабоать с бд
              try{
                    $NameBD = '';
                    $NameBuferTable = "BuferTable";
                    $NameBuferTable .= time();
                    // Создаём временную таблицу
                    Yii::$app->db->createCommand("
                        CREATE TABLE `".$NameBD."`.
                        `".$NameBuferTable."`
                        ( `id` INT NOT NULL ,
                         `Agregator` TEXT NOT NULL ,
                          `ArrayAgregator` TEXT NOT NULL )
                          ENGINE = InnoDB;")->execute();
                    Yii::$app->db->createCommand("BEGIN")->execute(); // Начали транзакцию

                foreach ($ArrayStringNameTable as  $value) {
                     ///TODO: Цыкл для обработки массива записи его в таблицы или в таблицы
                     /// надо понять что конкретно надо
                     ///  Возможно из этого цикла запись в модель User()
                }


                    Yii::$app->db->createCommand("COMMIT;")->execute();  // Закончили транзакцию
                     Yii::$app->db->createCommand("DROP ".$NameBuferTable."")->execute(); // Удалили буферную таблицу

                }catch (Exception $e) {
                        $this->ArrayIN_info = 'Ошибка в проверки валидации массива';
                        $this->KeyReady = FALSE;
                }






        }









    }
}
