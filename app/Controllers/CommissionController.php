<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParametreModel;

class CommissionController extends BaseController {
    protected $parametreModel;

    public function __construct() {
        $this->parametreModel = new ParametreModel();
    }

    public function index() {
        $commission = $this->parametreModel->getValeur('commission_transfert_inter_operateur', '2.5');

        return view('commission/gestion_commission', [
            'commission' => $commission,
        ]);
    }

    public function update() {
        $rules = [
            'commission' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $commission = (float)$this->request->getPost('commission');

        $this->parametreModel->setValeur('commission_transfert_inter_operateur', (string)$commission);

        return redirect()->to('admin/commission')->with('message', 'Commission mise à jour avec succès.');
    }
}
