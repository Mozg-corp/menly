<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%tariffs}}`
 */
class m210303_072758_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'id_users' => $this->integer()->notNull(),
            'id_tariffs' => $this->integer()->notNull(),
            'status' => $this->smallInteger(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-subscriptions-id_users}}',
            '{{%subscriptions}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-subscriptions-id_users}}',
            '{{%subscriptions}}',
            'id_users',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_tariffs`
        $this->createIndex(
            '{{%idx-subscriptions-id_tariffs}}',
            '{{%subscriptions}}',
            'id_tariffs'
        );

        // add foreign key for table `{{%tariffs}}`
        $this->addForeignKey(
            '{{%fk-subscriptions-id_tariffs}}',
            '{{%subscriptions}}',
            'id_tariffs',
            '{{%tariffs}}',
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
            '{{%fk-subscriptions-id_users}}',
            '{{%subscriptions}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-subscriptions-id_users}}',
            '{{%subscriptions}}'
        );

        // drops foreign key for table `{{%tariffs}}`
        $this->dropForeignKey(
            '{{%fk-subscriptions-id_tariffs}}',
            '{{%subscriptions}}'
        );

        // drops index for column `id_tariffs`
        $this->dropIndex(
            '{{%idx-subscriptions-id_tariffs}}',
            '{{%subscriptions}}'
        );

        $this->dropTable('{{%subscriptions}}');
    }
}
