<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%agregators}}`.
 */
class m201124_070059_add_logo_column_to_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%agregators}}', 'logo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%agregators}}', 'logo');
    }
}
