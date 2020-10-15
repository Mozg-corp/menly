<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%driver_accounts}}`.
 */
class m201013_094822_add_account_column_to_driver_accounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%driver_accounts}}', 'account', $this->string(32));
		  // creates index for column `account`
        $this->createIndex(
            '{{%idx-driver_accounts-account}}',
            '{{%driver_accounts}}',
            'account'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%driver_accounts}}', 'account');
		
		 // drops index for column `account`
        $this->dropIndex(
            '{{%idx-driver_accounts-account}}',
            '{{%driver_accounts}}'
        );
    }
}
