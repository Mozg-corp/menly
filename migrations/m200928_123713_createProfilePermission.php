<?php

use yii\db\Migration;

/**
 * Class m200928_123713_createProfilePermission
 */
class m200928_123713_createProfilePermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$role= $am->getRole('candidate');
		
		$createProfile= $am->createPermission('createProfile');
        $createProfile->description = 'Просмотр любых машин';

        $am->add($createProfile);
		
		$am->addChild($role, $createProfile);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$p = $am->getPermission('createProfile');
		$am->remove($p);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200928_123713_createProfilePermission cannot be reverted.\n";

        return false;
    }
    */
}
