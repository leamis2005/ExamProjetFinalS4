<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaremeFraisModel;
use App\Models\ParametreModel;
use App\Models\UtilisateurModel;
use App\Models\TransactionMmModel;
use App\Models\CommissionModel;
use App\Models\PrefixeModel;

class TransactionController extends BaseController {
    protected $utilisateurModel;
    protected $transactionModel;
    protected $baremeFraisModel;
    protected $parametreModel;
    protected $prefixeModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
        $this->transactionModel = new TransactionMmModel();
        $this->baremeFraisModel = new BaremeFraisModel();
        $this->parametreModel = new ParametreModel();
        $this->prefixeModel = new PrefixeModel();
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

        $expediteurTelephone = $client['telephone'];
        $operateurExpediteur = $this->prefixeModel->getOperateurByTelephone($expediteurTelephone);
        $operateurRecepteur = $this->prefixeModel->getOperateurByTelephone($recepteurTelephone);

        $commission = 0.0;
        $operateursDifferents = $operateurExpediteur && $operateurRecepteur &&
                                (int) $operateurExpediteur['id'] !== (int) $operateurRecepteur['id'];

        if ($operateursDifferents) {
            $pourcentageCommission = (float) $this->parametreModel->getValeur('commission_transfert_inter_operateur', '2.5');
            $commission = round($montant * ($pourcentageCommission / 100), 2);
        }

        $total = $montant + $frais + $commission;

        if ((float) $client['solde'] < $total) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour couvrir le montant, les frais et la commission.');
        }

        $this->transactionModel->insert([
            'type_operation_id' => 3,
            'expediteur' => $clientId,
            'recepteur' => $recepteur['id'],
            'montant' => $montant,
            'frais' => $frais,
            'commission' => $commission,
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

        if ($commission > 0) {
            $message .= ' Commission inter-opérateur : ' . number_format($commission, 2, ',', ' ') . ' Ar.';
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
