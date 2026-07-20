<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionMmModel;
use App\Models\UtilisateurModel;
use App\Models\PrefixeModel;

class SituationController extends BaseController {
    protected $transactionModel;
    protected $utilisateurModel;
    protected $prefixeModel;

    public function __construct() {
        $this->transactionModel = new TransactionMmModel();
        $this->utilisateurModel = new UtilisateurModel();
        $this->prefixeModel = new PrefixeModel();
    }

    public function index() {
        $db = \Config\Database::connect();

        $transferts = $db->table('transaction_mm')
            ->select('transaction_mm.*, expediteur.telephone AS expediteur_telephone')
            ->join('utilisateur expediteur', 'expediteur.id = transaction_mm.expediteur', 'left')
            ->where('transaction_mm.type_operation_id', 3)
            ->where('transaction_mm.commission >', 0)
            ->orderBy('transaction_mm.date_operation', 'DESC')
            ->get()
            ->getResultArray();

        $parOperateur = [];

        foreach ($transferts as $t) {
            $operateur = $this->prefixeModel->getOperateurByTelephone($t['expediteur_telephone'] ?? '');
            $nomOperateur = $operateur ? $operateur['nom'] : 'Inconnu';
            $idOperateur = $operateur ? $operateur['id'] : 0;

            if (!isset($parOperateur[$idOperateur])) {
                $parOperateur[$idOperateur] = [
                    'operateur_nom' => $nomOperateur,
                    'montant_a_reverser' => 0,
                    'nombre_transferts' => 0,
                ];
            }

            $parOperateur[$idOperateur]['montant_a_reverser'] += (float) ($t['commission'] ?? 0);
            $parOperateur[$idOperateur]['nombre_transferts']++;
        }

        usort($parOperateur, static fn ($a, $b) => $b['montant_a_reverser'] <=> $a['montant_a_reverser']);

        return view('situation/situation_operateurs', [
            'reversAuxOperateurs' => $parOperateur,
        ]);
    }
}
