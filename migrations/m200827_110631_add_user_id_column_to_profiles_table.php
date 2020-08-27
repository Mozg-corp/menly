<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profiles}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200827_110631_add_user_id_column_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profiles}}', 'user_id', $this->integer()->notNull());

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-profiles-user_id}}',
            '{{%profiles}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-profiles-user_id}}',
            '{{%profiles}}',
            'user_id',
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
            '{{%fk-profiles-user_id}}',
            '{{%profiles}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-profiles-user_id}}',
            '{{%profiles}}'
        );

        $this->dropColumn('{{%profiles}}', 'user_id');
    }
}
