<?php

use yii\db\Migration;

/**
 * Class m201113_130659_alter_id_driver_accounts_column_for_transfers_table
 */
class m201113_130659_alter_id_driver_accounts_column_for_transfers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		 // drops foreign key for table `{{%driver_accounts}}`
        $this->dropForeignKey(
            '{{%fk-transfers-id_driver_accounts}}',
            '{{%transfers}}'
        );

        // drops index for column `id_driver_accounts`
        $this->dropIndex(
            '{{%idx-transfers-id_driver_accounts}}',
            '{{%transfers}}'
        );
		$this->dropColumn('transfers', 'id_driver_accounts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		
		$this->addColumn('transfers', 'id_driver_accounts', $this->integer()->notNull());
		
		// creates index for column `id_driver_accounts`
        $this->createIndex(
            '{{%idx-transfers-id_driver_accounts}}',
            '{{%transfers}}',
            'id_driver_accounts'
        );

        // add foreign key for table `{{%driver_accounts}}`
        $this->addForeignKey(
            '{{%fk-transfers-id_driver_accounts}}',
            '{{%transfers}}',
            'id_driver_accounts',
            '{{%driver_accounts}}',
            'id',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201113_130659_alter_id_driver_accounts_column_for_transfers_table cannot be reverted.\n";

        return false;
    }
    */
}
