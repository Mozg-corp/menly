<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%agregators}}`.
 */
class m200929_143939_add_expire_column_to_agregators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%agregators}}', 'expire', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%agregators}}', 'expire');
    }
}
