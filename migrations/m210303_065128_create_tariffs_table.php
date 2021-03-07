<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tariffs}}`.
 */
class m210303_065128_create_tariffs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tariffs}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'subscription' => $this->float()->defaultValue(0),
            'rate' => $this->float()->defaultValue(0),
            'description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('name', '{{%tariffs}}');
        $this->dropTable('{{%tariffs}}');
    }
}
