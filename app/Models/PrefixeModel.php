<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model {
    protected $table = 'prefixe';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefixe', 'operateur_id'];
    protected $useTimestamps = false;
    public function getOperateurByTelephone(string $telephone): ?array {
        foreach ($this->findAll() as $p) {
            if (str_starts_with($telephone, (string)$p['prefixe'])) {
                return $this->db->table('operateur')
                                ->select('operateur.*')
                                ->where('operateur.id', $p['operateur_id'])
                                ->get()
                                ->getFirstRow('array');
            }
        }

        return null;
    }
}

?>