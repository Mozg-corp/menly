<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%agregators}}`.
 */
class m200826_113627_create_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agregators}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'apiv1' => $this->string(),
            'apiv2' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%agregators}}');
    }
}
