<?php

use yii\db\Migration;

/**
 * Class m200928_123526_viewAllCarsPermission
 */
class m200928_123526_viewAllCarsPermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$role= $am->getRole('admin')
		
		$viewAllCars= $am->createPermission('viewAllCars');
        $viewAllCars->description = 'Просмотр любых машин';

        $am->add($viewAllCars);
		
		$am->addChild($role, $viewAllCars);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200928_123526_viewAllCarsPermission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200928_123526_viewAllCarsPermission cannot be reverted.\n";

        return false;
    }
    */
}
