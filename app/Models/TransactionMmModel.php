<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionMmModel extends Model {
    protected $table = 'transaction_mm';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'expediteur', 'recepteur', 'montant', 'frais', 'commission', 'date_operation'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getDepotsByClient(int $clientId) {
        return $this->where('type_operation_id', 1)
                    ->where('recepteur', $clientId)
                    ->orderBy('date_operation', 'DESC')
                    ->findAll();
    }

    public function getHistoriqueByClient(int $clientId) {
        return $this->select('transaction_mm.*, type_operation.nom AS type_operation_nom, expediteur_client.telephone AS expediteur_telephone, recepteur_client.telephone AS recepteur_telephone')
                    ->join('type_operation', 'type_operation.id = transaction_mm.type_operation_id', 'left')
                    ->join('utilisateur expediteur_client', 'expediteur_client.id = transaction_mm.expediteur', 'left')
                    ->join('utilisateur recepteur_client', 'recepteur_client.id = transaction_mm.recepteur', 'left')
                    ->groupStart()
                        ->where('transaction_mm.expediteur', $clientId)
                        ->orWhere('transaction_mm.recepteur', $clientId)
                    ->groupEnd()
                    ->orderBy('transaction_mm.date_operation', 'DESC')
                    ->findAll();
    }

    public function getHistoriqueGlobal(int $limit = 50) {
        return $this->select('transaction_mm.*, type_operation.nom AS type_operation_nom, expediteur_client.telephone AS expediteur_telephone, recepteur_client.telephone AS recepteur_telephone')
                    ->join('type_operation', 'type_operation.id = transaction_mm.type_operation_id', 'left')
                    ->join('utilisateur expediteur_client', 'expediteur_client.id = transaction_mm.expediteur', 'left')
                    ->join('utilisateur recepteur_client', 'recepteur_client.id = transaction_mm.recepteur', 'left')
                    ->orderBy('transaction_mm.date_operation', 'DESC')
                    ->findAll($limit);
    }

    public function getSituationComptesClients() {
        return $this->db->table('utilisateur')
                        ->select('id, telephone, solde')
                        ->where('type_utilisateur_id', 2)
                        ->orderBy('telephone', 'ASC')
                        ->get()
                        ->getResultArray();
    }
}

?>
