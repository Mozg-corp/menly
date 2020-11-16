<?php

use yii\db\Migration;

/**
 * Class m201113_083757_create_transfer_permissions
 */
class m201113_083757_create_transfer_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$authManager = \Yii::$app->authManager;
		
		$createTransfer = $authManager->createPermission('createTransfer');
		$createTransfer->description = 'Создание перевода со счёта в агрегаторе';
		$authManager->add($createTransfer);
		
		$viewAllTransfers = $authManager->createPermission('viewAllTransfers');
		$viewAllTransfers->description = 'Смотреть список всех трансферов';
		$authManager->add($viewAllTransfers);
		
		$viewOwnTransfers = $authManager->createPermission('viewOwnTransfers');
		$viewOwnTransfers->description = 'Смотреть список своих трансферов';
		
		$transferOwnerRule = new \app\rules\TransferOwnerRule();
		$viewOwnTransfers->ruleName = $transferOwnerRule->name;
		
		$authManager->add($transferOwnerRule);
		$authManager->add($viewOwnTransfers);
		
		$updateAnyTransfer = $authManager->createPermission('updateAnyTransfer');
		$updateAnyTransfer->description = 'Обновлять любой трансфер';
		$authManager->add($updateAnyTransfer);
		
		$user = $authManager->getRole('user');
		$admin = $authManager->getRole('admin');
		
		$authManager->addChild($user, $createTransfer);
		$authManager->addChild($user, $viewOwnTransfers);
		$authManager->addChild($admin, $viewAllTransfers);
		$authManager->addChild($admin, $updateAnyTransfer);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $authManager = \Yii::$app->authManager;
	   $createTransfer = $authManager->getPermission('createTransfer');
	   $viewAllTransfers = $authManager->getPermission('viewAllTransfers');
	   $viewOwnTransfers = $authManager->getPermission('viewOwnTransfers');
	   $updateAnyTransfer = $authManager->getPermission('updateAnyTransfer');
	   $transferOwnerRule = $authManager->getRule('transferOwnerRule');
	   
	   $user = $authManager->getRole('user');
		$admin = $authManager->getRole('admin');
		
		$authManager->removeChild($user, $createTransfer);
		$authManager->removeChild($user, $viewOwnTransfers);
		$authManager->removeChild($admin, $viewAllTransfers);
		$authManager->removeChild($admin, $updateAnyTransfer);
		
	   $authManager->remove($viewOwnTransfers);
	   $authManager->remove($transferOwnerRule);
	   $authManager->remove($createTransfer);
	   $authManager->remove($viewAllTransfers);
	   $authManager->remove($updateAnyTransfer);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201113_083757_create_transfer_permissions cannot be reverted.\n";

        return false;
    }
    */
}
