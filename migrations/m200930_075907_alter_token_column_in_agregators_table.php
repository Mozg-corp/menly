<?php

use yii\db\Migration;

/**
 * Class m200930_075907_alter_token_column_in_agregators_table
 */
class m200930_075907_alter_token_column_in_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->alterColumn('agregators', 'token', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->alterColumn('agregators', 'token', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200930_075907_alter_token_column_in_agregators_table cannot be reverted.\n";

        return false;
    }
    */
}
