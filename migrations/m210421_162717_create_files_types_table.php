<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files_types}}`.
 */
class m210421_162717_create_files_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%files_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%files_types}}');
    }
}
