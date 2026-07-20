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
        $prefixes = ['prefixes' => $this->prefixeModel->findAll()];

        return view('prefixe/gestion_prefixe', $prefixes);
    }
}
?>