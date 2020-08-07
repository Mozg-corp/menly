<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200806_124717_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'id_users' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'body' => $this->text(),
            'preview' => $this->string(255),
            'img' => $this->string(100),
			'createAt'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
			'updatedAt'=>$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
			'postedAt'=>$this->timestamp(),
        ]);

        // creates index for column `id_users`
        $this->createIndex(
            '{{%idx-post-id_users}}',
            '{{%posts}}',
            'id_users'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-post-id_users}}',
            '{{%posts}}',
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
            '{{%fk-post-id_users}}',
            '{{%posts}}'
        );

        // drops index for column `id_users`
        $this->dropIndex(
            '{{%idx-post-id_users}}',
            '{{%posts}}'
        );

        $this->dropTable('{{%posts}}');
    }
}
