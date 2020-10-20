<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%gett_balances}}`.
 */
class m201020_073346_add_created_at_column_to_gett_balances_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gett_balances}}', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gett_balances}}', 'created_at');
    }
}
