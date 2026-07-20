<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeUtilisateurTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nom');
        $this->forge->createTable('type_utilisateur', true);
    }

    public function down()
    {
        $this->forge->dropTable('type_utilisateur', true);
    }
}
