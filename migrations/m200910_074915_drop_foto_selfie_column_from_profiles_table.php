<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%profiles}}`.
 */
class m200910_074915_drop_foto_selfie_column_from_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profiles}}', 'foto_selfie');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profiles}}', 'foto_selfie', $this->string());
    }
}
