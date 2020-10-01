<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%agregators}}`.
 */
class m200930_081447_add_refresh_token_column_to_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%agregators}}', 'refresh_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%agregators}}', 'refresh_token');
    }
}
