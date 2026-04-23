<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $count = $this->db->table('preguntas')->countAllResults();

        if ($count > 0) {
            return;
        }

        $rows = [
            ['pregunta' => '¿Cómo califica la rapidez del servicio?', 'categoria' => 'Servicio', 'orden' => 1],
            ['pregunta' => '¿Cómo califica la amabilidad del personal?', 'categoria' => 'Servicio', 'orden' => 2],
            ['pregunta' => '¿Cómo califica el sabor de los alimentos?', 'categoria' => 'Alimentos', 'orden' => 3],
            ['pregunta' => '¿Cómo califica la presentación de los platillos?', 'categoria' => 'Alimentos', 'orden' => 4],
            ['pregunta' => '¿Cómo califica la limpieza del restaurante?', 'categoria' => 'Instalaciones', 'orden' => 5],
            ['pregunta' => '¿Cómo califica su experiencia general?', 'categoria' => 'General', 'orden' => 6],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($rows as &$row) {
            $row['tipo'] = 'escala_1_5';
            $row['activa'] = 1;
            $row['is_deleted'] = 0;
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        $this->db->table('preguntas')->insertBatch($rows);
    }
}
