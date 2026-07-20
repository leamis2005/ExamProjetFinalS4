<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model {
    protected $table = 'commission';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pourcentage'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getPourcentage(float $default = 2.5): float {
        $row = $this->first();
        return $row ? (float) $row['pourcentage'] : $default;
    }

    public function setPourcentage(float $pourcentage): bool {
        $row = $this->first();

        if ($row) {
            return $this->update($row['id'], ['pourcentage' => $pourcentage]);
        }

        return $this->insert(['pourcentage' => $pourcentage]);
    }
}
