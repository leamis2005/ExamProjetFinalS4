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

    public function retrait() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        return view('client/retrait', ['client' => $client]);
    }

    public function effectuerRetrait() {
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $montant = (float) $this->request->getPost('montant');
        $frais = $this->calculerFrais(2, $montant);
        $total = $montant + $frais;

        if ((float) $client['solde'] < $total) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour couvrir le montant et les frais.');
        }

        $this->transactionModel->insert([
            'type_operation_id' => 2,
            'expediteur' => $clientId,
            'recepteur' => null,
            'montant' => $montant,
            'frais' => $frais,
            'date_operation' => date('Y-m-d H:i:s'),
        ]);

        $this->utilisateurModel->update($clientId, [
            'solde' => (float) $client['solde'] - $total,
        ]);

        $message = 'Retrait de ' . number_format($montant, 2, ',', ' ') . ' Ar effectué avec succès.';

        if ($frais > 0) {
            $message .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' Ar.';
        }

        return redirect()->to('client/dashboard')->with('message', $message);
    }

    public function transfert() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        return view('client/transfert', ['client' => $client]);
    }

    public function effectuerTransfert() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        $rules = [
            'telephone_recepteur' => 'required|min_length[10]|max_length[20]',
            'montant' => 'required|numeric|greater_than_equal_to[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recepteurTelephone = $this->request->getPost('telephone_recepteur');
        $recepteur = $this->utilisateurModel->getClientByTelephone($recepteurTelephone);

        if (!$recepteur) {
            return redirect()->back()->withInput()->with('error', 'Le destinataire est introuvable.');
        }

        if ((int) $recepteur['id'] === (int) $clientId) {
            return redirect()->back()->withInput()->with('error', 'Vous ne pouvez pas vous transférer à vous-même.');
        }

        $montant = (float) $this->request->getPost('montant');
        $frais = $this->calculerFrais(3, $montant);
        $total = $montant + $frais;

        if ((float) $client['solde'] < $total) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour couvrir le montant et les frais.');
        }

        $this->transactionModel->insert([
            'type_operation_id' => 3,
            'expediteur' => $clientId,
            'recepteur' => $recepteur['id'],
            'montant' => $montant,
            'frais' => $frais,
            'date_operation' => date('Y-m-d H:i:s'),
        ]);

        $this->utilisateurModel->update($clientId, [
            'solde' => (float) $client['solde'] - $total,
        ]);

        $this->utilisateurModel->update($recepteur['id'], [
            'solde' => (float) $recepteur['solde'] + $montant,
        ]);

        $message = 'Transfert de ' . number_format($montant, 2, ',', ' ') . ' Ar effectué avec succès vers ' . esc($recepteurTelephone) . '.';

        if ($frais > 0) {
            $message .= ' Frais appliqués : ' . number_format($frais, 2, ',', ' ') . ' Ar.';
        }

        return redirect()->to('client/dashboard')->with('message', $message);
    }

    public function historique() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            return redirect()->to('login')->with('error', 'Client introuvable.');
        }

        return view('client/historique', [
            'client' => $client,
            'operations' => $this->transactionModel->getHistoriqueByClient($clientId),
        ]);
    }
}

?>
