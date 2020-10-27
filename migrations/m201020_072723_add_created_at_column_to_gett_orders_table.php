<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%gett_orders}}`.
 */
class m201020_072723_add_created_at_column_to_gett_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gett_orders}}', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gett_orders}}', 'created_at');
    }
}
