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
		
		$viewAllCars= $am->createPermission('updateAnyCar');
        $viewAllCars->description = 'Изменение любой машины';

        $am->add($viewAllCars);
		$am->addChild($admin, $viewAllCars);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		        echo "m200919_174725_viewAllProfilesPermission cannot be reverted.\n";

        return false;
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
