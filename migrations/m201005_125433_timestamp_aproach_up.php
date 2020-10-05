<?php

use yii\db\Migration;

/**
 * Class m201005_125433_timestamp_aproach_up
 */
class m201005_125433_timestamp_aproach_up extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('cars','created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
		$this->addColumn('cars','updated_at', $this->timestamp());
		$this->renameColumn('profiles', 'createdAt', 'created_at');
		$this->renameColumn('profiles', 'updatedAt', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cars', 'created_at');
        $this->dropColumn('cars', 'updated_at');
		$this->renameColumn('profiles', 'created_at', 'createdAt');
		$this->renameColumn('profiles', 'updated_at', 'updatedAt');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201005_125433_timestamp_aproach_up cannot be reverted.\n";

        return false;
    }
    */
}
