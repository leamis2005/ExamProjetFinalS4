<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeFraisModel extends Model {
    protected $table = 'bareme_frais';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'montant_min', 'montant_max', 'frais'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getAllWithTypeOperation() {
        return $this->select('bareme_frais.*, type_operation.nom AS type_operation_nom')
                    ->join('type_operation', 'type_operation.id = bareme_frais.type_operation_id', 'left')
                    ->orderBy('type_operation_id', 'ASC')
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }

    public function getApplicableBareme(int $typeOperationId, float $montant): ?array {
        return $this->where('type_operation_id', $typeOperationId)
                    ->where('montant_min <=', $montant)
                    ->where('montant_max >=', $montant)
                    ->orderBy('montant_min', 'DESC')
                    ->first();
    }

    public function getGainsByOperation(): array {
        return $this->db->table('transaction_mm')
                        ->select('type_operation.nom AS type_operation_nom, SUM(transaction_mm.frais) AS gain_total')
                        ->join('type_operation', 'type_operation.id = transaction_mm.type_operation_id', 'left')
                        ->groupBy('transaction_mm.type_operation_id')
                        ->orderBy('type_operation.nom', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    public function getGainsParCategorie(): array {
        $row = $this->db->table('transaction_mm')
                        ->select('COALESCE(SUM(transaction_mm.frais), 0) AS gains_internes')
                        ->select('COALESCE(SUM(CASE WHEN transaction_mm.type_operation_id = 3 AND transaction_mm.commission > 0 THEN transaction_mm.commission ELSE 0 END), 0) AS gains_inter_operateurs')
                        ->get()
                        ->getFirstRow('array') ?? [];

        $gainsInternes = (float) ($row['gains_internes'] ?? 0);
        $gainsInterOperateurs = (float) ($row['gains_inter_operateurs'] ?? 0);

        return [
            'gains_internes' => $gainsInternes,
            'gains_inter_operateurs' => $gainsInterOperateurs,
            'gain_total' => $gainsInternes + $gainsInterOperateurs,
        ];
    }
}

?>