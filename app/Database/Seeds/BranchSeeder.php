<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $count = $this->db->table('sucursales')->countAllResults();

        if ($count > 0) {
            return;
        }

        $rows = [
            [
                'nombre'     => 'Sucursal Centro',
                'direccion'  => 'Av. Principal #100',
                'telefono'   => '555-0101',
                'activa'     => 1,
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre'     => 'Sucursal Norte',
                'direccion'  => 'Blvd. Norte #250',
                'telefono'   => '555-0102',
                'activa'     => 1,
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('sucursales')->insertBatch($rows);
    }
}
