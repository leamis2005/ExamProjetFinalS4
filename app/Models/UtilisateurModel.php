<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model {
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telephone', 'solde', 'type_utilisateur_id'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $validationRules = [
        'telephone'          => 'required|min_length[10]|max_length[20]|is_unique[utilisateur.telephone]',
        'solde'              => 'permit_empty|numeric|greater_than_equal_to[0]',
        'type_utilisateur_id' => 'required|integer|is_not_unique[type_utilisateur.id]',
    ];

    protected $validationMessages = [
        'telephone' => [
            'required'   => 'Le numéro de téléphone est obligatoire.',
            'is_unique' => 'Ce numéro de téléphone existe déjà.',
            'min_length' => 'Le numéro de téléphone doit contenir au moins 10 caractères.',
        ],
    ];

    public function getClientById(int $id) {
        return $this->where('type_utilisateur_id', 2)->find($id);
    }

    public function getClientByTelephone(string $telephone) {
        return $this->where('type_utilisateur_id', 2)
                    ->where('telephone', $telephone)
                    ->first();
    }

    public function getAllClients() {
        return $this->where('type_utilisateur_id', 2)->findAll();
    }
}

?>
