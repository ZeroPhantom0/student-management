<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
                'on update' => 'CURRENT_TIMESTAMP'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'updated_at');
    }
}