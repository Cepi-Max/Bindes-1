<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Padi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_petani' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama_pabrik' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'jumlah_padi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_padi');
    }

    public function down()
    {
        $this->forge->dropTable('data_padi');
    }
}
