<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profiles}}`.
 */
class m200826_113815_create_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profiles}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(50)->notNull(),
            'secondname' => $this->string(50),
            'lastname' => $this->string(50)->notNull(),
            'phone' => $this->string(20),
            'birthdate' => $this->timestamp()->defaultValue(null),
            'passport_series' => $this->string(4),
            'passport_number' => $this->string(6),
            'passport_giver' => $this->string(),
            'passport_date' => $this->timestamp()->defaultValue(null),
            'registration_address' => $this->string(),
            'license_series' => $this->string(4),
            'license_number' => $this->string(6),
            'license_date' => $this->timestamp()->defaultValue(null),
            'license_expire' => $this->timestamp()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profiles}}');
    }
}
