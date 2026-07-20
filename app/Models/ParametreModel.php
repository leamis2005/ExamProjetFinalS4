<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model {
    protected $table = 'parametre';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cle', 'valeur'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getValeur(string $cle, string $default = ''): string {
        $row = $this->where('cle', $cle)->first();

        return $row ? (string) $row['valeur'] : $default;
    }

    public function setValeur(string $cle, string $valeur): bool {
        $row = $this->where('cle', $cle)->first();

        if ($row) {
            return (bool) $this->update($row['id'], ['valeur' => $valeur]);
        }

        return (bool) $this->insert([
            'cle' => $cle,
            'valeur' => $valeur,
        ]);
    }
}
