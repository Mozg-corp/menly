<?php

use yii\db\Migration;

/**
 * Class m201112_081938_insert_transfer_statuses
 */
class m201112_081938_insert_transfer_statuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$connection = \Yii::$app->db;
		$connection->createCommand()->batchInsert('transfer_statuses', ['status'], [
			['Создан'],
			['Списано'],
			['Переведено'],
			['Отклонено'],
			['Ошибка']
		])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$connection = \Yii::$app->db;
		$connection->createCommand()->delete('transfer_statuses')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_081938_insert_transfer_statuses cannot be reverted.\n";

        return false;
    }
    */
}
