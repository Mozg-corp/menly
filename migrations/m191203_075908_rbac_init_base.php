<?php

use app\rules\MeterOwnerRule;
use yii\db\Migration;

/**
 * Class m191203_075908_rbac_init_base
 */
class m191203_075908_rbac_init_base extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $authManager = \Yii::$app->authManager;

        $admin = $authManager->createRole('admin');
        $admin->description = 'Роль админа';
        $authManager->add($admin);

        $user = $authManager->createRole('user');
        $user->description = 'Роль пользователя';
        $authManager->add($user);
		
		$candidate = $authManager->createRole('candidate');
        $candidate->description = 'Роль кандидата';
		$authManager->add($candidate);

        $createAllItems = $authManager->createPermission('createAllItems');
        $createAllItems->description = 'Создание любых видов сущностей';
        $authManager->add($createAllItems);

        $authManager->addChild($admin,$user);
        $authManager->addChild($admin, $createAllItems);

        $authManager->assign($admin, 1);
        // $authManager->assign($user, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191203_075908_rbac_init_base cannot be reverted.\n";

        return false;
    }
    */
}
