<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class AuthController extends BaseController {
    protected $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
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
            return redirect()->back()->withInput()->with('error', 'Aucun compte associé à ce numéro.');
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

    public function logout() {
        session()->remove(['client_id', 'client_telephone', 'admin_id', 'admin_telephone']);
        session()->regenerate(true);
        session()->destroy();
        return redirect()->to('login')->with('message', 'Déconnexion réussie.');
    }
}

?>
