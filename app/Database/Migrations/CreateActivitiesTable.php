<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'activity_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'details' => [
                'type' => 'TEXT'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45
            ],
            'created_at timestamp DEFAULT current_timestamp()'
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('activities');
    }

    public function down()
    {
        $this->forge->dropTable('activities');
    }
}