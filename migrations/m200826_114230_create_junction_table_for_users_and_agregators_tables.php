<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_agregators}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%agregators}}`
 */
class m200826_114230_create_junction_table_for_users_and_agregators_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_agregators}}', [
            'users_id' => $this->integer()->notNull(),
            'agregators_id' => $this->integer()->notNull(),
            'id' => $this->primaryKey()
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-users_agregators-users_id}}',
            '{{%users_agregators}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_agregators-users_id}}',
            '{{%users_agregators}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `agregators_id`
        $this->createIndex(
            '{{%idx-users_agregators-agregators_id}}',
            '{{%users_agregators}}',
            'agregators_id'
        );

        // add foreign key for table `{{%agregators}}`
        $this->addForeignKey(
            '{{%fk-users_agregators-agregators_id}}',
            '{{%users_agregators}}',
            'agregators_id',
            '{{%agregators}}',
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
            '{{%fk-users_agregators-users_id}}',
            '{{%users_agregators}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-users_agregators-users_id}}',
            '{{%users_agregators}}'
        );

        // drops foreign key for table `{{%agregators}}`
        $this->dropForeignKey(
            '{{%fk-users_agregators-agregators_id}}',
            '{{%users_agregators}}'
        );

        // drops index for column `agregators_id`
        $this->dropIndex(
            '{{%idx-users_agregators-agregators_id}}',
            '{{%users_agregators}}'
        );

        $this->dropTable('{{%users_agregators}}');
    }
}
