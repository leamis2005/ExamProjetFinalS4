<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionMmTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type_operation_id' => [
                'type'     => 'INTEGER',
                'unsigned' => true,
                'null'     => false,
            ],
            'expediteur' => [
                'type'     => 'INTEGER',
                'unsigned' => true,
                'null'     => true,
            ],
            'recepteur' => [
                'type'     => 'INTEGER',
                'unsigned' => true,
                'null'     => true,
            ],
            'montant' => [
                'type'    => 'REAL',
                'null'    => false,
            ],
            'frais' => [
                'type'    => 'REAL',
                'default' => 0,
            ],
            'date_operation' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_operation_id', 'type_operation', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('expediteur', 'utilisateur', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('recepteur', 'utilisateur', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('transaction_mm');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_mm');
    }
}
