<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTendersTable extends Migration
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
            'tender_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'LONGTEXT',
            ],
            'organ_of_state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'province_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tender_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => 'e.g., goods, services, works',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'closed', 'awarded'],
                'default' => 'active',
            ],
            'opening_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'closing_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'published_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'budget_estimate' => [
                'type' => 'DECIMAL',
                'constraint' => [15, 2],
                'null' => true,
            ],
            'api_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'unique' => true,
                'comment' => 'External API ID for sync',
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
        $this->forge->addForeignKey('organ_of_state_id', 'organs_of_state', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('province_id', 'provinces', 'id', '', 'CASCADE');
        $this->forge->addIndex(['status', 'closing_date']);
        $this->forge->createTable('tenders');
    }

    public function down()
    {
        $this->forge->dropTable('tenders');
    }
}
