<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeUtilisateurModel extends Model {
    protected $table = 'type_utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}

?>
