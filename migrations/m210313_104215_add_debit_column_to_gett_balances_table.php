<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%gett_balances}}`.
 */
class m210313_104215_add_debit_column_to_gett_balances_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gett_balances}}', 'debit', $this->float()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gett_balances}}', 'debit');
    }
}
