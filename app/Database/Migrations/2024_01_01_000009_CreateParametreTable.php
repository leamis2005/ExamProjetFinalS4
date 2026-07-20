<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParametreTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cle' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'valeur' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('cle');
        $this->forge->createTable('parametre', true);
    }

    public function down()
    {
        $this->forge->dropTable('parametre', true);
    }
}
