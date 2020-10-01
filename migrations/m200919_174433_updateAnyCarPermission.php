<?php

use yii\db\Migration;

/**
 * Class m200919_174433_updateAnyCarPermission
 */
class m200919_174433_updateAnyCarPermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$admin= $am->getRole('admin');
		
		$updateAnyCar= $am->createPermission('updateAnyCar');
        $updateAnyCar->description = 'Изменение любой машины';

        $am->add($updateAnyCar);
		$am->addChild($admin, $updateAnyCar);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$am = \Yii::$app->authManager;
		$p = $am->getPermission('updateAnyCar');
		$am->remove($p);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200919_174433_updateAnyCarPermission cannot be reverted.\n";

        return false;
    }
    */
}
