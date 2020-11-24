<?php

use yii\db\Migration;

/**
 * Class m201124_070551_insert_logos_to_agregators_table
 */
class m201124_070551_insert_logos_to_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$connection = \Yii::$app->db;
		
		$connection->createCommand()
			->update('agregators', ['logo' => 'gett_logo.png'], 'name = "Gett"')
			->execute();
		$connection->createCommand()
			->update('agregators', ['logo' => 'yandex_logo.png'], 'name = "Яндекс"')
			->execute();
		$connection->createCommand()
			->update('agregators', ['logo' => 'citymobil_logo.png'], 'name = "Ситимобиль"')
			->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$connection = \Yii::$app->db;
		
		$connection->createCommand()
			->update('agregators', ['logo' => ''], 'name = "Gett"')
			->execute();
		$connection->createCommand()
			->update('agregators', ['logo' => ''], 'name = "Яндекс"')
			->execute();
		$connection->createCommand()
			->update('agregators', ['logo' => ''], 'name = "Ситимобиль"')
			->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201124_070551_insert_logos_to_agregators_table cannot be reverted.\n";

        return false;
    }
    */
}
