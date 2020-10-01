<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%agregators}}`.
 */
class m200929_143828_add_token_column_to_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%agregators}}', 'token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%agregators}}', 'token');
    }
}
