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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%driver_accounts}}', 'account');
    }
}
