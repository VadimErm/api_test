<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tweeterUsers`.
 */
class m180804_165009_create_tweeterUsers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tweeterUsers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tweeterUsers');
    }
}
