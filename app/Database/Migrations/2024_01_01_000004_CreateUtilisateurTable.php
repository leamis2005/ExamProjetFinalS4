<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUtilisateurTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'telephone' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'solde' => [
                'type'    => 'REAL',
                'default' => 0,
            ],
            'type_utilisateur_id' => [
                'type'     => 'INTEGER',
                'unsigned' => true,
                'null'     => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('telephone');
        $this->forge->addForeignKey('type_utilisateur_id', 'type_utilisateur', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('utilisateur', true);
    }

    public function down()
    {
        $this->forge->dropTable('utilisateur', true);
    }
}
