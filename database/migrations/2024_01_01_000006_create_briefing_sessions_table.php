<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBriefingSessionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tender_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'time' => [
                'type' => 'TIME',
            ],
            'venue' => [
                'type' => 'TEXT',
            ],
            'is_virtual' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'virtual_link' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tender_id', 'tenders', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('tender_id', 'tenders', 'id', '', 'CASCADE');
        $this->forge->createTable('briefing_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('briefing_sessions');
    }
}
