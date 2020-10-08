<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m200827_084103_add_updatedAt_column_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profiles}}', 'updatedAt', $this->timestamp()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profiles}}', 'updatedAt');
    }
}
