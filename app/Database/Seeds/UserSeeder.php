<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $exists = $this->db->table('usuarios')->where('username', 'admin')->countAllResults();

        if ($exists > 0) {
            return;
        }

        $this->db->table('usuarios')->insert([
            'username'      => 'admin',
            'password_hash' => password_hash('Admin12345*', PASSWORD_DEFAULT),
            'name'          => 'Administrador',
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
