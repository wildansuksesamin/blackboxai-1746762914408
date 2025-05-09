<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTkdnApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tkdn_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'submitted', 'review', 'approved', 'rejected'],
                'default' => 'draft',
            ],
            'submission_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'approval_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tkdn_applications');
    }

    public function down()
    {
        $this->forge->dropTable('tkdn_applications');
    }
}
