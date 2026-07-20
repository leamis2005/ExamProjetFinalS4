<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionMmModel extends Model {
    protected $table = 'transaction_mm';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'expediteur', 'recepteur', 'montant', 'frais', 'date_operation'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getDepotsByClient(int $clientId) {
        return $this->where('type_operation_id', 1)
                    ->where('recepteur', $clientId)
                    ->orderBy('date_operation', 'DESC')
                    ->findAll();
    }
}

?>
