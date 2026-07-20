<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaremeFraisModel;
use App\Models\TransactionMmModel;
use App\Models\UtilisateurModel;

class TableauDeBordController extends BaseController {
    protected $transactionModel;
    protected $utilisateurModel;
    protected $baremeFraisModel;

    public function __construct() {
        $this->transactionModel = new TransactionMmModel();
        $this->utilisateurModel = new UtilisateurModel();
        $this->baremeFraisModel = new BaremeFraisModel();
    }

    public function index() {
        $db = \Config\Database::connect();
        $gainTotal = array_sum(array_map(static fn ($row) => (float) ($row['gain_total'] ?? 0), $this->baremeFraisModel->getGainsByOperation()));

        $commissionInterOperateur = (float) $db->table('transaction_mm')
            ->where('type_operation_id', 3)
            ->where('commission >', 0)
            ->selectSum('commission', 'total_commission')
            ->get()
            ->getFirstRow('array')['total_commission'] ?? 0;

        return view('admin/tableau_de_bord', [
            'gainTotal' => $gainTotal,
            'commissionInterOperateur' => $commissionInterOperateur,
            'clientsCount' => count($this->utilisateurModel->getAllClients()),
            'operationsRecentes' => $this->transactionModel->getHistoriqueGlobal(10),
            'situationClients' => $this->transactionModel->getSituationComptesClients(),
        ]);
    }
}

?>