<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrefixeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'prefixe' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'operateur_id' => [
                'type'     => 'INTEGER',
                'unsigned' => true,
                'null'     => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('prefixe');
        $this->forge->addForeignKey('operateur_id', 'operateur', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prefixe', true);
    }

    public function down()
    {
        $this->forge->dropTable('prefixe', true);
    }
}
