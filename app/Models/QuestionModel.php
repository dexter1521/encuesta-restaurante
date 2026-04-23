<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table            = 'preguntas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pregunta',
        'categoria',
        'tipo',
        'orden',
        'activa',
        'is_deleted',
        'deleted_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'orden' => 'integer',
        'activa' => 'integer',
        'is_deleted' => 'integer',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function activeQuestions(): array
    {
        return $this->where('activa', 1)
            ->where('is_deleted', 0)
            ->orderBy('orden', 'ASC')
            ->findAll();
    }
}
