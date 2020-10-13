<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%driver_accounts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%agregators}}`
 * - `{{%account_types}}`
 */
class m201013_060925_create_driver_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%driver_accounts}}', [
            'id' => $this->primaryKey(),
            'id_agregator' => $this->integer()->notNull(),
            'id_account_types' => $this->integer()->notNull(),
        ]);

        // creates index for column `id_agregator`
        $this->createIndex(
            '{{%idx-driver_accounts-id_agregator}}',
            '{{%driver_accounts}}',
            'id_agregator'
        );

        // add foreign key for table `{{%agregators}}`
        $this->addForeignKey(
            '{{%fk-driver_accounts-id_agregator}}',
            '{{%driver_accounts}}',
            'id_agregator',
            '{{%agregators}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_account_types`
        $this->createIndex(
            '{{%idx-driver_accounts-id_account_types}}',
            '{{%driver_accounts}}',
            'id_account_types'
        );

        // add foreign key for table `{{%account_types}}`
        $this->addForeignKey(
            '{{%fk-driver_accounts-id_account_types}}',
            '{{%driver_accounts}}',
            'id_account_types',
            '{{%account_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%agregators}}`
        $this->dropForeignKey(
            '{{%fk-driver_accounts-id_agregator}}',
            '{{%driver_accounts}}'
        );

        // drops index for column `id_agregator`
        $this->dropIndex(
            '{{%idx-driver_accounts-id_agregator}}',
            '{{%driver_accounts}}'
        );

        // drops foreign key for table `{{%account_types}}`
        $this->dropForeignKey(
            '{{%fk-driver_accounts-id_account_types}}',
            '{{%driver_accounts}}'
        );

        // drops index for column `id_account_types`
        $this->dropIndex(
            '{{%idx-driver_accounts-id_account_types}}',
            '{{%driver_accounts}}'
        );

        $this->dropTable('{{%driver_accounts}}');
    }
}
