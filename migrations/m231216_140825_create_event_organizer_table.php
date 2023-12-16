<?php

use yii\db\Migration;

class m231216_140825_create_event_organizer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%event_organizer}}', [
            'event_id' => $this->integer()->notNull(),
            'organizer_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->addForeignKey('fk-event_organizer-event_id-event-id', '{{%event_organizer}}', 'event_id', '{{%event}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-event_organizer-organizer_id-organizer-id', '{{%event_organizer}}', 'organizer_id', '{{%organizer}}', 'id', 'CASCADE', 'CASCADE');
        $this->addPrimaryKey('pk-event_organizer', '{{%event_organizer}}', ['event_id', 'organizer_id']);
    }

    public function safeDown()
    {
        $this->dropPrimaryKey('pk-event_organizer', '{{%event_organizer}}');
        $this->dropForeignKey('fk-event_organizer-event_id-event-id', '{{%event_organizer}}');
        $this->dropForeignKey('fk-event_organizer-organizer_id-organizer-id', '{{%event_organizer}}');
        $this->dropTable('{{%event_organizer}}');
    }
}