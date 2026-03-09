<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTenderEnquiriesTable extends Migration
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
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'fax' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
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
        $this->forge->createTable('tender_enquiries');
    }

    public function down()
    {
        $this->forge->dropTable('tender_enquiries');
    }
}
