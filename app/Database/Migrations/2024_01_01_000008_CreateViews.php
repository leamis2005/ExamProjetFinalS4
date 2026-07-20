<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViews extends Migration
{
    public function up()
    {
        $this->db->query('
            CREATE VIEW v_gain_operateur AS
            SELECT SUM(frais) AS gain_total
            FROM transaction_mm
        ');

        $this->db->query('
            CREATE VIEW v_situation_client AS
            SELECT
                id,
                nom,
                telephone,
                solde
            FROM utilisateur
            WHERE type_utilisateur_id = 2
        ');
    }

    public function down()
    {
        $this->db->query('DROP VIEW IF EXISTS v_gain_operateur');
        $this->db->query('DROP VIEW IF EXISTS v_situation_client');
    }
}
