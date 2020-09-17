<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%profiles}}`.
 */
class m200910_075313_drop_foto_passport_registrationpage_column_from_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%profiles}}', 'foto_passport_registrationpage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%profiles}}', 'foto_passport_registrationpage', $this->string());
    }
}
