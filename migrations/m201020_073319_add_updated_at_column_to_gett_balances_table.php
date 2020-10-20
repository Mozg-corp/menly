<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%gett_balances}}`.
 */
class m201020_073319_add_updated_at_column_to_gett_balances_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gett_balances}}', 'updated_at', $this->timestamp());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gett_balances}}', 'updated_at');
    }
}
