<?php

use yii\db\Migration;

/**
 * Class m201110_131108_fillAgregatorsTable
 */
class m201110_131108_fillAgregatorsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$yandex = new \app\models\Agregator();
		$yandex->name = 'Яндекс';
		$yandex->apiv1 = 'https://fleet-api.taxi.yandex.net/v1';
		$yandex->apiv2 = 'https://fleet-api.taxi.yandex.net/v2';
		$yandex->save();
		
		$citymobil = new \app\models\Agregator();
		$citymobil->name = 'Ситимобиль';
		$citymobil->apiv1 = 'https://fleet.city-mobil.ru/api/1.0';
		$citymobil->apiv2 = 'https://fleet.city-mobil.ru/api/2.0';
		$citymobil->save();
		
		$gett = new \app\models\Agregator();
		$gett->name = 'Gett';
		$gett->apiv1 = 'https://gettpartner.ru/api/fleet/v1';
		$gett->apiv2 = 'https://gettpartner.ru/api/fleet/v2';
		$gett->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \app\models\Agregator::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201110_131108_fillAgregatorsTable cannot be reverted.\n";

        return false;
    }
    */
}
