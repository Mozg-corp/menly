<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gett_orders}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%driver_accounts}}`
 */
class m201015_082847_create_gett_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gett_orders}}', [
            'id' => $this->primaryKey(),
            'id_ride' => $this->integer()->notNull()->unique(),
            'id_driver' => $this->string(32)->notNull(),
            'cost_for_driver_wo_tips' => $this->double()->defaultValue(0.0),
            'parking_cost' => $this->double()->defaultValue(0.0),
            'collected_from_client' => $this->double()->defaultValue(0.0),
            'driver_tips' => $this->double()->defaultValue(0.0)
        ]);

        // creates index for column `id_driver`
        $this->createIndex(
            '{{%idx-gett_orders-id_driver}}',
            '{{%gett_orders}}',
            'id_driver'
        );

        // add foreign key for table `{{%driver_accounts}}`
        $this->addForeignKey(
            '{{%fk-gett_orders-id_driver}}',
            '{{%gett_orders}}',
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
            '{{%fk-gett_orders-id_driver}}',
            '{{%gett_orders}}'
        );

        // drops index for column `id_driver`
        $this->dropIndex(
            '{{%idx-gett_orders-id_driver}}',
            '{{%gett_orders}}'
        );

        $this->dropTable('{{%gett_orders}}');
    }
}
