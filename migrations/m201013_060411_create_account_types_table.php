<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account_types}}`.
 */
class m201013_060411_create_account_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account_types}}');
    }
}
