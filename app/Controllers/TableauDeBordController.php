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
        return view('admin/tableau_de_bord', [
            'gainTotal' => array_sum(array_map(static fn ($row) => (float) ($row['gain_total'] ?? 0), $this->baremeFraisModel->getGainsByOperation())),
            'clientsCount' => count($this->utilisateurModel->getAllClients()),
            'operationsRecentes' => $this->transactionModel->getHistoriqueGlobal(10),
            'situationClients' => $this->transactionModel->getSituationComptesClients(),
        ]);
    }
}

?>