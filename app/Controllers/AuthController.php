<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController {
    protected $utilisateurModel;
    protected $prefixeModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
        $this->prefixeModel = new PrefixeModel();
    }

    public function login() {
        return view('auth/login');
    }

    public function attemptLogin() {
        $telephone = $this->request->getPost('telephone');

        if (empty($telephone)) {
            return redirect()->back()->withInput()->with('error', 'Le numéro de téléphone est obligatoire.');
        }

        $utilisateur = $this->utilisateurModel
            ->where('telephone', $telephone)
            ->first();

        if (!$utilisateur) {
            if (!$this->prefixeValide($telephone)) {
                return redirect()->back()->withInput()->with('error', 'Le numéro ne commence par aucun préfixe d\'opérateur valide (032, 033, 034, 037, 038...).');
            }

            $id = $this->utilisateurModel->insert([
                'telephone'           => $telephone,
                'solde'               => 0,
                'type_utilisateur_id' => 2,
            ]);
            $utilisateur = $this->utilisateurModel->find($id);
        }

        session()->regenerate();

        if ((int)$utilisateur['type_utilisateur_id'] === 1) {
            session()->set('admin_id', $utilisateur['id']);
            session()->set('admin_telephone', $utilisateur['telephone']);
            return redirect()->to('admin/clients')->with('bienvenue', 'Bienvenue admin');
        }

        session()->set('client_id', $utilisateur['id']);
        session()->set('client_telephone', $utilisateur['telephone']);
        return redirect()->to('client/dashboard')->with('bienvenue', 'Bienvenue ' . $utilisateur['telephone']);
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

    public function logout() {
        session()->remove(['client_id', 'client_telephone', 'admin_id', 'admin_telephone']);
        session()->regenerate(true);
        session()->destroy();
        return redirect()->to('login')->with('message', 'Déconnexion réussie.');
    }
}

?>
