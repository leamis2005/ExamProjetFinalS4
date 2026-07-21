<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommissionModel;

class CommissionController extends BaseController {
    protected $commissionModel;

    public function __construct() {
        $this->commissionModel = new CommissionModel();
    }

    public function index() {
        $operateurs = $this->commissionModel->getOperateursAvecCommission(2.5);

        return view('commission/gestion_commission', [
            'operateurs' => $operateurs,
        ]);
    }

    public function update() {
        $operateurs = $this->commissionModel->getOperateursAvecCommission(2.5);

        foreach ($operateurs as $operateur) {
            $field = 'commission_' . $operateur['id'];
            $rules[$field] = 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        foreach ($operateurs as $operateur) {
            $field = 'commission_' . $operateur['id'];
            $this->commissionModel->setPourcentageForOperateur(
                (int) $operateur['id'],
                (float) $this->request->getPost($field)
            );
        }

        return redirect()->to('admin/commission')->with('message', 'Commissions mises à jour avec succès.');
    }
}
