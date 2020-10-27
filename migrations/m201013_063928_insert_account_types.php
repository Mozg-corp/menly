<?php

use yii\db\Migration;

/**
 * Class m201013_063928_insert_account_types
 */
class m201013_063928_insert_account_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$driver_account_type = new \app\models\AccountType();
		$driver_account_type->name = "driver";
		$driver_account_type->save();
		
		$car_account_type = new \app\models\AccountType();
		$car_account_type->name = "car";
		$car_account_type->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $driver_account_type = \app\models\AccountType::find()->where(['name' => 'driver'])->one();
		$driver_account_type->delete();
        $car_account_type = \app\models\AccountType::find()->where(['name' => 'car'])->one();
		$car_account_type->delete();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201013_063928_insert_account_types cannot be reverted.\n";

        return false;
    }
    */
}
