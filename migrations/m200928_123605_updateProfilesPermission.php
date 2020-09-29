<?php

use yii\db\Migration;

/**
 * Class m200928_123605_updateProfilesPermission
 */
class m200928_123605_updateProfilesPermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$role= $am->getRole('admin');
		
		$updateProfiles= $am->createPermission('updateProfiles');
        $updateProfiles->description = 'Просмотр любых машин';

        $am->add($updateProfiles);
		
		$am->addChild($role, $updateProfiles);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$p = $am->getPermission('updateProfiles');
		$am->remove($p);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200928_123605_updateProfilesPermission cannot be reverted.\n";

        return false;
    }
    */
}
