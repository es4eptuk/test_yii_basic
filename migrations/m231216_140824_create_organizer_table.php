<?php

use \yii\db\Migration;

class m231216_140824_create_organizer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%organizer}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->defaultValue(null),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%organizer}}');
    }
}