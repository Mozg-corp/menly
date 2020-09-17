<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%profiles}}`.
 */
class m200910_075107_drop_foto_passport_fotopage_column_from_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profiles}}', 'foto_passport_fotopage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profiles}}', 'foto_passport_fotopage', $this->string());
    }
}
