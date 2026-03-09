<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTenderCategoriesTable extends Migration
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
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tender_id', 'tenders', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', '', 'CASCADE');
        $this->forge->addUniqueKey(['tender_id', 'category_id']);
        $this->forge->createTable('tender_categories');
    }

    public function down()
    {
        $this->forge->dropTable('tender_categories');
    }
}
