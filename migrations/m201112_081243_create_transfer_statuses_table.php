<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfer_statuses}}`.
 */
class m201112_081243_create_transfer_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfer_statuses}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string(30),
            'created_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transfer_statuses}}');
    }
}
