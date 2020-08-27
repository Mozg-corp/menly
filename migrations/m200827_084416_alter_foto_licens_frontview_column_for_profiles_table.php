<?php

use yii\db\Migration;

/**
 * Class m200827_084416_alter_foto_licens_frontview_column_for_profiles_table
 */
class m200827_084416_alter_foto_licens_frontview_column_for_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->renameColumn('profiles', 'foto_licens_frontview', 'foto_license_frontview');
		$this->renameColumn('profiles', 'foto_licens_backview', 'foto_license_backview');
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('profiles', 'foto_license_frontview', 'foto_licens_frontview');
		$this->renameColumn('profiles', 'foto_license_backview', 'foto_licens_backview');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200827_084416_alter_foto_licens_frontview_column_for_profiles_table cannot be reverted.\n";

        return false;
    }
    */
}
