<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('operateur')->insertBatch([
            ['nom' => 'yas'],
            ['nom' => 'autre operateur'],
        ]);

        $this->db->table('prefixe')->insertBatch([
            ['prefixe' => '034', 'operateur_id' => 1],
            ['prefixe' => '038', 'operateur_id' => 1],
        ]);

        $this->db->table('type_utilisateur')->insertBatch([
            ['nom' => 'ADMIN'],
            ['nom' => 'CLIENT'],
        ]);

        $this->db->table('utilisateur')->insertBatch([
            ['telephone' => '0000000000', 'solde' => 0, 'type_utilisateur_id' => 1],
        ]);

        $this->db->table('type_operation')->insertBatch([
            ['nom' => 'Depot'],
            ['nom' => 'Retrait'],
            ['nom' => 'Transfert'],
        ]);

        $this->db->table('bareme_frais')->insertBatch([
            ['type_operation_id' => 2, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['type_operation_id' => 2, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['type_operation_id' => 2, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['type_operation_id' => 2, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['type_operation_id' => 2, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['type_operation_id' => 2, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],
            ['type_operation_id' => 2, 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500],
            ['type_operation_id' => 2, 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 2500],
            ['type_operation_id' => 2, 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500],
            ['type_operation_id' => 2, 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
        ]);
    }
}
