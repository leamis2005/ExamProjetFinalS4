<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixeController extends BaseController {
    protected $prefixeModel;

    public function __construct() {
        $this->prefixeModel = new PrefixeModel();
    }

    public function  index() {
        $builder = $this->prefixeModel->builder();
        $builder->select('prefixe.*, operateur.nom AS operateur_nom');
        $builder->join('operateur', 'operateur.id = prefixe.operateur_id', 'left');
        $prefixes = ['prefixes' => $builder->get()->getResultArray()];

        return view('prefixe/gestion_prefixe', $prefixes);
    }

    public function ajouter() {
        $data = [
            'titre'        => 'Ajouter un préfixe',
            'prefixe'      => null,
            'operateurs'   => $this->prefixeModel->db->table('operateur')->get()->getResult(),
        ];

        return view('prefixe/ajouter', $data);
    }

    public function store() {
        $rules = [
            'prefixe'      => 'required|max_length[10]',
            'operateur_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->prefixeModel->save([
            'prefixe'      => $this->request->getPost('prefixe'),
            'operateur_id' => $this->request->getPost('operateur_id'),
        ]);

        return redirect()->to('admin/prefixes')->with('message', 'Préfixe ajouté avec succès.');
    }

    public function modifier($id = null) {
        $prefixe = $this->prefixeModel->find($id);

        if (! $prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Préfixe introuvable');
        }

        $data = [
            'titre'        => 'Modifier le préfixe',
            'prefixe'      => $prefixe,
            'operateurs'   => $this->prefixeModel->db->table('operateur')->get()->getResult(),
        ];

        return view('prefixe/ajouter', $data);
    }

    public function update($id = null) {
        $prefixe = $this->prefixeModel->find($id);

        if (! $prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Préfixe introuvable');
        }

        $rules = [
            'prefixe'      => 'required|max_length[10]',
            'operateur_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->prefixeModel->update($id, [
            'prefixe'      => $this->request->getPost('prefixe'),
            'operateur_id' => $this->request->getPost('operateur_id'),
        ]);

        return redirect()->to('admin/prefixes')->with('message', 'Préfixe modifié avec succès.');
    }

    public function supprimer($id = null) {
        $prefixe = $this->prefixeModel->find($id);

        if (! $prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Préfixe introuvable');
        }

        $this->prefixeModel->delete($id);

        return redirect()->to('admin/prefixes')->with('message', 'Préfixe supprimé avec succès.');
    }
}
