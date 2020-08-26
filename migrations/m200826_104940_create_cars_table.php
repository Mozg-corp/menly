<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200826_104940_create_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cars}}', [
            'id' => $this->primaryKey(),
            'brand' => $this->string(50),
            'model' => $this->string(50),
            'year' => $this->string(4),
            'color' => $this->string(50),
            'registration' => $this->string(9),
            'vin' => $this->string(17),
            'sts' => $this->string(10),
            'license' => $this->string(10),
            'id_users' => $this->integer()->notNull(),
        ]);

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-cars-id_users}}',
            '{{%cars}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-cars-id_users}}',
            '{{%cars}}',
            'id_users',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-cars-id_users}}',
            '{{%cars}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-cars-id_users}}',
            '{{%cars}}'
        );

        $this->dropTable('{{%cars}}');
    }
}
