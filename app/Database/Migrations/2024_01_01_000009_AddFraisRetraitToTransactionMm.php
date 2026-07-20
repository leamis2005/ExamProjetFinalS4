<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFraisRetraitToTransactionMm extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction_mm', [
            'frais_retrait' => [
                'type'    => 'REAL',
                'null'    => true,
                'default' => null,
                'after'   => 'frais',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction_mm', 'frais_retrait');
    }
}
