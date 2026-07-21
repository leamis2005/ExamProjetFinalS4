<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model {
    protected $table = 'parametre';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cle', 'valeur'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getPourcentage(float $default = 2.5): float {
        try {
            if ($this->db->tableExists('parametre')) {
                $row = $this->db->table('parametre')
                    ->where('cle', 'commission_transfert_inter_operateur')
                    ->get()
                    ->getFirstRow('array');

                if ($row) {
                    return (float) ($row['valeur'] ?? $default);
                }
            }

            if ($this->db->tableExists('commission')) {
                $row = $this->db->table('commission')
                    ->get()
                    ->getFirstRow('array');

                if ($row) {
                    return (float) ($row['pourcentage'] ?? $default);
                }
            }
        } catch (\Throwable) {
            // Fall through to the default commission when the database is not ready.
        }

        return $default;
    }

    public function getPourcentageForOperateur(int $operateurId, float $default = 2.5): float {
        $key = 'commission_transfert_inter_operateur_' . $operateurId;

        try {
            if ($this->db->tableExists('parametre')) {
                $row = $this->db->table('parametre')
                    ->where('cle', $key)
                    ->get()
                    ->getFirstRow('array');

                if ($row) {
                    return (float) ($row['valeur'] ?? $default);
                }
            }
        } catch (\Throwable) {
            // Fall through to the global/default commission when the database is not ready.
        }

        return $this->getPourcentage($default);
    }

    public function setPourcentage(float $pourcentage): bool {
        try {
            if ($this->db->tableExists('parametre')) {
                $row = $this->db->table('parametre')
                    ->where('cle', 'commission_transfert_inter_operateur')
                    ->get()
                    ->getFirstRow('array');

                if ($row) {
                    return (bool) $this->db->table('parametre')
                        ->where('id', $row['id'])
                        ->update(['valeur' => (string) $pourcentage]);
                }

                return (bool) $this->db->table('parametre')->insert([
                    'cle' => 'commission_transfert_inter_operateur',
                    'valeur' => (string) $pourcentage,
                ]);
            }

            if ($this->db->tableExists('commission')) {
                $row = $this->db->table('commission')->get()->getFirstRow('array');

                if ($row) {
                    return (bool) $this->db->table('commission')
                        ->where('id', $row['id'])
                        ->update(['pourcentage' => $pourcentage]);
                }

                return (bool) $this->db->table('commission')->insert([
                    'pourcentage' => $pourcentage,
                ]);
            }
        } catch (\Throwable) {
            // Fall through to the default commission when the database is not ready.
        }

        return false;
    }

    public function setPourcentageForOperateur(int $operateurId, float $pourcentage): bool {
        $key = 'commission_transfert_inter_operateur_' . $operateurId;

        try {
            if ($this->db->tableExists('parametre')) {
                $row = $this->db->table('parametre')
                    ->where('cle', $key)
                    ->get()
                    ->getFirstRow('array');

                if ($row) {
                    return (bool) $this->db->table('parametre')
                        ->where('id', $row['id'])
                        ->update(['valeur' => (string) $pourcentage]);
                }

                return (bool) $this->db->table('parametre')->insert([
                    'cle' => $key,
                    'valeur' => (string) $pourcentage,
                ]);
            }
        } catch (\Throwable) {
            // Fall through when the database is not ready.
        }

        return false;
    }

    public function getOperateursAvecCommission(float $default = 2.5): array {
        try {
            if ($this->db->tableExists('operateur')) {
                $operateurs = $this->db->table('operateur')
                    ->get()
                    ->getResultArray();

                foreach ($operateurs as &$op) {
                    $op['commission'] = $this->getPourcentageForOperateur((int) $op['id'], $default);
                }

                return $operateurs;
            }
        } catch (\Throwable) {
            // Fall through when the database is not ready.
        }

        return [];
    }
}


