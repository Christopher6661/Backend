<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaModel extends Model{
    protected $table = 'receta';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['Categoria'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'Categoria' => 'required|alpha_space|min_length[3]|max_length[100]'
    ];

    protected $validationMessages = [
        'Categoria' => [
            'required' => 'El campo Categoria es obligatorio',
            'alpha_space' => 'El campo Categoria debe contener solo letras',
            'min_length' => 'el campo Categoria debe tener al menos 3 caracteres',
            'max_length' => 'el campo Categoria debe tener al menos 100 caracteres'
        ]
    ];
    protected $skipValidation = false;
}

?>