<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%driver_accounts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m201013_064851_add_id_users_column_to_driver_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%driver_accounts}}', 'id_users', $this->integer()->notNull());

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-driver_accounts-id_users}}',
            '{{%driver_accounts}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-driver_accounts-id_users}}',
            '{{%driver_accounts}}',
            'id_users',
            '{{%users}}',
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
            '{{%fk-driver_accounts-id_users}}',
            '{{%driver_accounts}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-driver_accounts-id_users}}',
            '{{%driver_accounts}}'
        );

        $this->dropColumn('{{%driver_accounts}}', 'id_users');
    }
}
