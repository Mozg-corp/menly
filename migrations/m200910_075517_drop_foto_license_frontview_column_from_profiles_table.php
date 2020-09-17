<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%profiles}}`.
 */
class m200910_075517_drop_foto_license_frontview_column_from_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profiles}}', 'foto_license_frontview');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profiles}}', 'foto_license_frontview', $this->string());
    }
}
