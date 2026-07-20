<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;
use App\Models\TypeUtilisateurModel;
use App\Models\PrefixeModel;
use App\Models\TransactionMmModel;

class ClientController extends BaseController {
    protected $utilisateurModel;
    protected $typeUtilisateurModel;
    protected $prefixeModel;
    protected $transactionModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
        $this->typeUtilisateurModel = new TypeUtilisateurModel();
        $this->prefixeModel = new PrefixeModel();
        $this->transactionModel = new TransactionMmModel();
    }

    public function index() {
        $data = [
            'clients' => $this->utilisateurModel->getAllClients(),
        ];

        return view('client/gestion_client', $data);
    }

    public function create() {
        return view('client/form_client');
    }

    public function store() {
        $rules = [
            'telephone' => 'required|min_length[10]|max_length[20]|is_unique[utilisateur.telephone]',
            'solde'     => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        if (!$this->prefixeValide($this->request->getPost('telephone'))) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', ['telephone' => 'Le numéro ne commence par aucun préfixe d\'opérateur valide (032, 033, 034, 037, 038...).']);
        }

        $this->utilisateurModel->insert([
            'telephone'           => $this->request->getPost('telephone'),
            'solde'               => $this->request->getPost('solde') ?? 0,
            'type_utilisateur_id' => 2,
        ]);

        return redirect()->to('admin/clients')->with('message', 'Compte client créé avec succès.');
    }

    public function edit(int $id) {
        $client = $this->utilisateurModel->getClientById($id);

        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client introuvable');
        }

        return view('client/form_client', ['client' => $client]);
    }

    public function update(int $id) {
        $client = $this->utilisateurModel->getClientById($id);

        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client introuvable');
        }

        $rules = [
            'telephone' => "required|min_length[10]|max_length[20]|is_unique[utilisateur.telephone,id,{$id}]",
            'solde'     => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        if (!$this->prefixeValide($this->request->getPost('telephone'))) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', ['telephone' => 'Le numéro ne commence par aucun préfixe d\'opérateur valide (032, 033, 034, 037, 038...).']);
        }

        $this->utilisateurModel->update($id, [
            'telephone' => $this->request->getPost('telephone'),
            'solde'     => $this->request->getPost('solde') ?? 0,
        ]);

        return redirect()->to('admin/clients')->with('message', 'Compte client mis à jour.');
    }

    public function delete(int $id) {
        $client = $this->utilisateurModel->getClientById($id);

        if ($client) {
            $this->utilisateurModel->delete($id);
        }

        return redirect()->to('admin/clients')->with('message', 'Compte client supprimé.');
    }

    public function login(string $telephone) {
        if (empty($telephone)) {
            return redirect()->to('admin/clients')->with('error', 'Numéro de téléphone requis.');
        }

        $client = $this->utilisateurModel->getClientByTelephone($telephone);

        if (!$client) {
            return redirect()->to('admin/clients')->with('error', 'Aucun client trouvé avec ce numéro.');
        }

        session()->set('client_id', $client['id']);
        session()->set('client_telephone', $client['telephone']);

        return redirect()->to('client/dashboard')->with('message', 'Connexion automatique réussie.');
    }

    public function dashboard() {
        $clientId = session()->get('client_id');

        if (!$clientId) {
            return redirect()->to('admin/clients')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->utilisateurModel->getClientById($clientId);

        if (!$client) {
            session()->remove(['client_id', 'client_telephone']);
            return redirect()->to('admin/clients')->with('error', 'Client introuvable.');
        }

        return view('client/dashboard', ['client' => $client]);
    }

    public function historique(int $id) {
        $client = $this->utilisateurModel->getClientById($id);

        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Client introuvable');
        }

        $operations = $this->transactionModel->getHistoriqueByClient($id);

        return view('client/historique_admin', [
            'client' => $client,
            'operations' => $operations,
        ]);
    }

    private function prefixeValide(string $telephone): bool {
        $prefixes = $this->prefixeModel->findColumn('prefixe');

        if (empty($prefixes)) {
            return false;
        }

        foreach ($prefixes as $prefixe) {
            if (str_starts_with($telephone, (string)$prefixe)) {
                return true;
            }
        }

        return false;
    }
}

?>
