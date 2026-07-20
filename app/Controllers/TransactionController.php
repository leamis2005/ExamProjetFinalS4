<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaremeFraisModel;
use App\Models\UtilisateurModel;
use App\Models\TransactionMmModel;

class TransactionController extends BaseController {
    protected $utilisateurModel;
    protected $transactionModel;
    protected $baremeFraisModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
        $this->transactionModel = new TransactionMmModel();
        $this->baremeFraisModel = new BaremeFraisModel();
    }

    protected function calculerFrais(int $typeOperationId, float $montant): float {
        $bareme = $this->baremeFraisModel->getApplicableBareme($typeOperationId, $montant);

        return $bareme ? (float) $bareme['frais'] : 0.0;
    }

    public function depot() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        return view('client/depot', ['client' => $client]);
    }

    public function effectuerDepot() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        $rules = [
            'montant' => 'required|numeric|greater_than_equal_to[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $montant = (float)$this->request->getPost('montant');
        $frais = $this->calculerFrais(1, $montant);

        $this->transactionModel->insert([
            'type_operation_id' => 1,
            'expediteur'        => null,
            'recepteur'         => $clientId,
            'montant'           => $montant,
            'frais'             => $frais,
            'date_operation'    => date('Y-m-d H:i:s'),
        ]);

        $this->utilisateurModel->update($clientId, [
            'solde' => (float)$client['solde'] + $montant,
        ]);

        $message = 'Dépôt de ' . number_format($montant, 2, ',', ' ') . ' Ar effectué avec succès.';

        if ($frais > 0) {
            $message .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' Ar.';
        }

        return redirect()->to('client/dashboard')->with('message', $message);
    }
}

?>
