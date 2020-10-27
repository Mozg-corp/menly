<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gett_balance}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%driver_accounts}}`
 */
class m201015_083351_create_gett_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gett_balances}}', [
            'id' => $this->primaryKey(),
            'id_driver' => $this->string(32)->notNull(),
            'balance' => $this->double()->defaultValue(0.0),
            'tips' => $this->double()->defaultValue(0.0),
            'parking_cost' => $this->double()->defaultValue(0.0),
        ]);

        // creates index for column `id_driver`
        $this->createIndex(
            '{{%idx-gett_balances-id_driver}}',
            '{{%gett_balances}}',
            'id_driver'
        );

        // add foreign key for table `{{%driver_accounts}}`
        $this->addForeignKey(
            '{{%fk-gett_balances-id_driver}}',
            '{{%gett_balances}}',
            'id_driver',
            '{{%driver_accounts}}',
            'account',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%driver_accounts}}`
        $this->dropForeignKey(
            '{{%fk-gett_balances-id_driver}}',
            '{{%gett_balances}}'
        );

        // drops index for column `id_driver`
        $this->dropIndex(
            '{{%idx-gett_balances-id_driver}}',
            '{{%gett_balances}}'
        );

        $this->dropTable('{{%gett_balances}}');
    }
}
