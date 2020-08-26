<?php

use yii\db\Migration;

/**
 * Class m200826_124355_alter_profile_table
 */
class m200826_124355_alter_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('profiles', 'foto_selfie', $this->string());
		$this->addColumn('profiles', 'foto_passport_fotopage', $this->string());
		$this->addColumn('profiles', 'foto_passport_registrationpage', $this->string());
		$this->addColumn('profiles', 'foto_licens_frontview', $this->string());
		$this->addColumn('profiles', 'foto_licens_backview', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profiles', 'foto_selfie');
        $this->dropColumn('profiles', 'foto_passport_fotopage');
        $this->dropColumn('profiles', 'foto_passport_registrationpage');
        $this->dropColumn('profiles', 'foto_licens_frontview');
        $this->dropColumn('profiles', 'foto_licens_backview');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_124355_alter_profile_table cannot be reverted.\n";

        return false;
    }
    */
}
