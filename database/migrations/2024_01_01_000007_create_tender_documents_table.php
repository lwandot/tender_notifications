<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTenderDocumentsTable extends Migration
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
            'document_name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'file_size' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'download_count' => [
                'type' => 'INT',
                'default' => 0,
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
        $this->forge->createTable('tender_documents');
    }

    public function down()
    {
        $this->forge->dropTable('tender_documents');
    }
}
