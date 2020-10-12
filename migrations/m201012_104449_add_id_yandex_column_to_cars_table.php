<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cars}}`.
 */
class m201012_104449_add_id_yandex_column_to_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cars}}', 'id_yandex', $this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cars}}', 'id_yandex');
    }
}
