<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_fotos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%files_types}}`
 * - `{{%users}}`
 */
class m210421_163133_create_users_fotos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_fotos}}', [
            'id' => $this->primaryKey(),
            'file' => $this->text()->notNull(),
            'id_files_types' => $this->integer()->defaultValue(1),
            'id_users' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()
        ]);

        // creates index for column `id_files_types`
        $this->createIndex(
            '{{%idx-users_fotos-id_files_types}}',
            '{{%users_fotos}}',
            'id_files_types'
        );

        // add foreign key for table `{{%files_types}}`
        $this->addForeignKey(
            '{{%fk-users_fotos-id_files_types}}',
            '{{%users_fotos}}',
            'id_files_types',
            '{{%files_types}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-users_fotos-id_users}}',
            '{{%users_fotos}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_fotos-id_users}}',
            '{{%users_fotos}}',
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
        // drops foreign key for table `{{%files_types}}`
        $this->dropForeignKey(
            '{{%fk-users_fotos-id_files_types}}',
            '{{%users_fotos}}'
        );

        // drops index for column `id_files_types`
        $this->dropIndex(
            '{{%idx-users_fotos-id_files_types}}',
            '{{%users_fotos}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_fotos-id_users}}',
            '{{%users_fotos}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-users_fotos-id_users}}',
            '{{%users_fotos}}'
        );

        $this->dropTable('{{%users_fotos}}');
    }
}
