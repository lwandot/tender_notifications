<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSubscriptionsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'notification_type' => [
                'type' => 'ENUM',
                'constraint' => ['email', 'push', 'sms'],
                'default' => 'email',
            ],
            'filter_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => 'category, province, organ_of_state',
                'null' => true,
            ],
            'filter_value' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'push_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'For push notifications',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addIndex(['user_id', 'is_active']);
        $this->forge->createTable('user_subscriptions');
    }

    public function down()
    {
        $this->forge->dropTable('user_subscriptions');
    }
}
