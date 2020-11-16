<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%agregators}}`
 * - `{{%transfer_statuses}}`
 * - `{{%driver_accounts}}`
 */
class m201112_124049_create_transfers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfers}}', [
            'id' => $this->primaryKey(),
            'id_users' => $this->integer()->notNull(),
            'id_agregators' => $this->integer()->notNull(),
            'id_transfer_statuses' => $this->integer()->notNull()->defaultValue(1),
            'transfer' => $this->string(50),
            'description' => $this->string(),
            'agregator_transfer_id' => $this->string(50),
            'bank_transfer_id' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultValue(null),
            'id_driver_accounts' => $this->integer()->notNull(),
        ]);

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-transfers-id_users}}',
            '{{%transfers}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-transfers-id_users}}',
            '{{%transfers}}',
            'id_users',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_agregators`
        $this->createIndex(
            '{{%idx-transfers-id_agregators}}',
            '{{%transfers}}',
            'id_agregators'
        );

        // add foreign key for table `{{%agregators}}`
        $this->addForeignKey(
            '{{%fk-transfers-id_agregators}}',
            '{{%transfers}}',
            'id_agregators',
            '{{%agregators}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_transfer_statuses`
        $this->createIndex(
            '{{%idx-transfers-id_transfer_statuses}}',
            '{{%transfers}}',
            'id_transfer_statuses'
        );

        // add foreign key for table `{{%transfer_statuses}}`
        $this->addForeignKey(
            '{{%fk-transfers-id_transfer_statuses}}',
            '{{%transfers}}',
            'id_transfer_statuses',
            '{{%transfer_statuses}}',
            'id',
            'CASCADE'
        );

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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-transfers-id_users}}',
            '{{%transfers}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-transfers-id_users}}',
            '{{%transfers}}'
        );

        // drops foreign key for table `{{%agregators}}`
        $this->dropForeignKey(
            '{{%fk-transfers-id_agregators}}',
            '{{%transfers}}'
        );

        // drops index for column `id_agregators`
        $this->dropIndex(
            '{{%idx-transfers-id_agregators}}',
            '{{%transfers}}'
        );

        // drops foreign key for table `{{%transfer_statuses}}`
        $this->dropForeignKey(
            '{{%fk-transfers-id_transfer_statuses}}',
            '{{%transfers}}'
        );

        // drops index for column `id_transfer_statuses`
        $this->dropIndex(
            '{{%idx-transfers-id_transfer_statuses}}',
            '{{%transfers}}'
        );

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

        $this->dropTable('{{%transfers}}');
    }
}
