<?php

use yii\db\Migration;

/**
 * Class m200928_122821_viewOwnProfilePermission
 */
class m200928_122821_viewOwnProfilePermission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		
		$role= $am->getRole('candidate')
		
		$viewOwnProfile= $am->createPermission('viewOwnProfile');
        $viewOwnProfile->description = 'Просмотр своего Профиля';

        $rule = new \app\rules\ProfileOwnerRule();
        $viewOwnProfile->ruleName = $rule->name;

        $am->add($rule);
        $am->add($viewOwnProfile);
		
		$am->addChild($role, $viewOwnProfile);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200928_122821_viewOwnProfilePermission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200928_122821_viewOwnProfilePermission cannot be reverted.\n";

        return false;
    }
    */
}
