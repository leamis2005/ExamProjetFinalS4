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
            // Fall through to the file fallback when the database is not ready.
        }

        return $this->readFallbackCommission($default);
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
            // Fall through to the file fallback when the database is not ready.
        }

        return $this->writeFallbackCommission($pourcentage);
    }

    protected function fallbackPath(): string {
        return WRITEPATH . 'settings/commission.json';
    }

    protected function readFallbackCommission(float $default): float {
        $path = $this->fallbackPath();

        if (! is_file($path)) {
            return $default;
        }

        $data = json_decode((string) file_get_contents($path), true);

        return is_array($data) && isset($data['pourcentage'])
            ? (float) $data['pourcentage']
            : $default;
    }

    protected function writeFallbackCommission(float $pourcentage): bool {
        $path = $this->fallbackPath();
        $directory = dirname($path);

        if (! is_dir($directory) && ! mkdir($directory, 0777, true) && ! is_dir($directory)) {
            return false;
        }

        return (bool) file_put_contents($path, json_encode([
            'pourcentage' => $pourcentage,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
