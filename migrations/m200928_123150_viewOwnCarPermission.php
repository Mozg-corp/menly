<?php

use yii\db\Migration;

/**
 * Class m200928_123150_viewOwnCarPermission
 */
class m200928_123150_viewOwnCarPermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$role= $am->getRole('candidate');
		
		$viewOwnCar= $am->createPermission('viewOwnCar');
        $viewOwnCar->description = 'Просмотр своей машины';

        $rule = new \app\rules\CarOwnerRule();
        $viewOwnCar->ruleName = $rule->name;

        $am->add($rule);
        $am->add($viewOwnCar);
		
		$am->addChild($role, $viewOwnCar);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$p = $am->getPermission('viewOwnCar');
		$r = $am->getRule('carOwnerRule');
		$am->remove($r);
		$am->remove($p);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200928_123150_viewOwnCarPermission cannot be reverted.\n";

        return false;
    }
    */
}
