<?php

use yii\db\Migration;

/**
 * Class m200824_113240_phone_not_null
 */
class m200824_113240_phone_not_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->alterColumn('users', 'phone', $this->string(20)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'phone', $this->string(50));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200824_113240_phone_not_null cannot be reverted.\n";

        return false;
    }
    */
}
