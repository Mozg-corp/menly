<?php

use yii\db\Migration;

/**
 * Class m200919_174725_viewAllProfilesPermission
 */
class m200919_174725_viewAllProfilesPermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$admin= $am->getRole('admin');
		
		$viewAllProfiles= $am->createPermission('viewAllProfiles');
        $viewAllProfiles->description = 'Просмотр любого профиля';

        $am->add($viewAllProfiles);
		$am->addChild($admin, $viewAllProfiles);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$p = $am->getPermission('updateAnyCar');
		$admin= $am->getRole('admin');
		$am->removeChild($admin, $p);
		$am->remove($p);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200919_174725_viewAllProfilesPermission cannot be reverted.\n";

        return false;
    }
    */
}
