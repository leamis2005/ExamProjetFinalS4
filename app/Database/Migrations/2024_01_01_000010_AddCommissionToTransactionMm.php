<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommissionToTransactionMm extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('commission', 'transaction_mm')) {
            $fields = [
                'commission' => [
                    'type'    => 'REAL',
                    'default' => 0,
                    'null'    => false,
                ],
            ];

            $this->forge->addColumn('transaction_mm', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('commission', 'transaction_mm')) {
            $this->forge->dropColumn('transaction_mm', 'commission');
        }
    }
}
