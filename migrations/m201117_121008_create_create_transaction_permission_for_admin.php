<?php

use yii\db\Migration;

/**
 * Class m201117_121008_create_create_transaction_permission_for_admin
 */
class m201117_121008_create_create_transaction_permission_for_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$am = \Yii::$app->authManager;
		$adminRole = $am->getRole('admin');
		$createTransaction = $am->createPermission('createTransaction');
		$createTransaction->description = 'Списание со счёта водителя у агрегатора';
		
		$am->add($createTransaction);
		$am->addChild($adminRole, $createTransaction);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $am = \Yii::$app->authManager;
		$adminRole = $am->getRole('admin');
		$createTransaction = $am->getPermission('createTransaction');
		
		$am->removeChild($adminRole, $createTransaction);
		$am->remove($createTransaction);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201117_121008_create_create_transaction_permission_for_admin cannot be reverted.\n";

        return false;
    }
    */
}
