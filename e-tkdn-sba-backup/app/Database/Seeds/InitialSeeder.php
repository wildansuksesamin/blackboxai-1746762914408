<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Add admin user
        $data = [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'System Administrator',
            'role' => 'admin',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($data);

        // Add sample TKDN application
        $data = [
            'company_name' => 'PT Example Company',
            'product_name' => 'Sample Product',
            'product_description' => 'This is a sample product description for testing purposes.',
            'tkdn_percentage' => 75.50,
            'status' => 'review',
            'created_by' => 1, // Admin user ID
            'submission_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('tkdn_applications')->insert($data);
    }
}
