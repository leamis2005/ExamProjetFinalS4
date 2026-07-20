<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaremeFraisTable extends Migration
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
            'montant_min' => [
                'type'    => 'REAL',
                'null'    => false,
            ],
            'montant_max' => [
                'type'    => 'REAL',
                'null'    => false,
            ],
            'frais' => [
                'type'    => 'REAL',
                'null'    => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_operation_id', 'type_operation', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bareme_frais');
    }

    public function down()
    {
        $this->forge->dropTable('bareme_frais');
    }
}
