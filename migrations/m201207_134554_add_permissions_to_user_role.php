<?php

use yii\db\Migration;

/**
 * Class m201207_134554_add_permissions_to_user_role
 */
class m201207_134554_add_permissions_to_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		$roleUser = $am->getRole('user');
		$viewOwnProfile = $am->getPermission('viewOwnProfile');
		$viewOwnCar = $am->getPermission('viewOwnCar');
		
		$am->addChild($roleUser, $viewOwnProfile);
		$am->addChild($roleUser, $viewOwnCar);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$roleUser = $am->getRole('user');
		$viewOwnProfile = $am->getPermission('viewOwnProfile');
		$viewOwnCar = $am->getPermission('viewOwnCar');
		
		$am->removeChild($roleUser, $viewOwnProfile);
		$am->removeChild($roleUser, $viewOwnCar);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201207_134554_add_permissions_to_user_role cannot be reverted.\n";

        return false;
    }
    */
}
