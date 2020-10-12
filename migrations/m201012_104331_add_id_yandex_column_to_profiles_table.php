<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m201012_104331_add_id_yandex_column_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profiles}}', 'id_yandex', $this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profiles}}', 'id_yandex');
    }
}
