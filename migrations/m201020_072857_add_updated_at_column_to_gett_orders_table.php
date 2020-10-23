<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%gett_orders}}`.
 */
class m201020_072857_add_updated_at_column_to_gett_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gett_orders}}', 'updated_at', $this->timestamp()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gett_orders}}', 'updated_at');
    }
}
