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
}

?>