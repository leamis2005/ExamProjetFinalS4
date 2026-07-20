<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaremeFraisModel;
use App\Models\TypeOperationModel;

class FraisController extends BaseController {
    protected $baremeFraisModel;
    protected $typeOperationModel;

    public function __construct() {
        $this->baremeFraisModel = new BaremeFraisModel();
        $this->typeOperationModel = new TypeOperationModel();
    }

    public function index() {
        return view('frais/gestion_frais', [
            'baremes' => $this->baremeFraisModel->getAllWithTypeOperation(),
            'gains' => $this->baremeFraisModel->getGainsByOperation(),
        ]);
    }

    public function create() {
        return view('frais/form_frais', [
            'bareme' => null,
            'typeOperations' => $this->typeOperationModel->findAll(),
        ]);
    }

    public function store() {
        $rules = [
            'type_operation_id' => 'required|integer',
            'montant_min' => 'required|numeric|greater_than_equal_to[0]',
            'montant_max' => 'required|numeric|greater_than_equal_to[0]',
            'frais' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');

        if ($montantMax < $montantMin) {
            return redirect()->back()->withInput()->with('errors', ["Le montant maximum doit être supérieur ou égal au montant minimum."]);
        }

        $this->baremeFraisModel->insert([
            'type_operation_id' => (int) $this->request->getPost('type_operation_id'),
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => (float) $this->request->getPost('frais'),
        ]);

        return redirect()->to('admin/frais')->with('message', 'Barème de frais ajouté avec succès.');
    }

    public function edit(int $id) {
        $bareme = $this->baremeFraisModel->find($id);

        if (! $bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barème introuvable');
        }

        return view('frais/form_frais', [
            'bareme' => $bareme,
            'typeOperations' => $this->typeOperationModel->findAll(),
        ]);
    }

    public function update(int $id) {
        $bareme = $this->baremeFraisModel->find($id);

        if (! $bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barème introuvable');
        }

        $rules = [
            'type_operation_id' => 'required|integer',
            'montant_min' => 'required|numeric|greater_than_equal_to[0]',
            'montant_max' => 'required|numeric|greater_than_equal_to[0]',
            'frais' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');

        if ($montantMax < $montantMin) {
            return redirect()->back()->withInput()->with('errors', ["Le montant maximum doit être supérieur ou égal au montant minimum."]);
        }

        $this->baremeFraisModel->update($id, [
            'type_operation_id' => (int) $this->request->getPost('type_operation_id'),
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => (float) $this->request->getPost('frais'),
        ]);

        return redirect()->to('admin/frais')->with('message', 'Barème de frais mis à jour.');
    }

    public function delete(int $id) {
        $bareme = $this->baremeFraisModel->find($id);

        if (! $bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barème introuvable');
        }

        $this->baremeFraisModel->delete($id);

        return redirect()->to('admin/frais')->with('message', 'Barème de frais supprimé.');
    }
}

?>