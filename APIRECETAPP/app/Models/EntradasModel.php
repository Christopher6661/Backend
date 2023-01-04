<?php
namespace App\Models;
use CodeIgniter\Model;

class EntradasModel extends Model{
    protected $table = 'entradas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['descripcion', 'ingredientes', 'tiempo_preparacion', 'preparacion', 'id_categoria'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'descripcion' => 'required|min_length[3]|max_length[100]',
        'ingredientes' => 'required|min_length[3]|max_length[100]',
        'tiempo_preparacion' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'preparacion' => 'required|min_length[3]|max_length[250]',
        'id_categoria' => 'required|is_natural_no_zero'
    ];
    protected $validationMessages = [
        'descripcion' => [
            'required' => 'El campo descripcion es obligatorio',
            'min_length' => 'El campo descripcion debe tener al menos 3 caracteres',
            'max_length' => 'El campo descripcion debe tener maximo 100 caracteres'
        ],
        'ingredientes' => [
            'required' => 'El campo ingredientes es obligatorio',
            'min_length' => 'El campo ingredientes debe tener al menos 3 caracteres',
            'max_length' => 'El campo ingredientes debe tener maximo 100 caracteres'
        ],
        'tiempo_preparacion' => [
            'required' => 'El campo tiempo preparacion es obligatorio',
            'alpha_numeric_space' => 'El campo tiempo preparacion debe contener solo letras y numeros',
            'min_length' => 'El campo tiempo preparacion debe tener al menos 3 caracteres',
            'max_length' => 'El campo tiempo preparacion debe tener maximo 100 caracteres'
        ],
        'preparacion' => [
            'required' => 'El campo preparacion es obligatorio',
            'min_length' => 'El campo preparacion debe tener al menos 3 caracteres',
            'max_length' => 'El campo preparacion debe tener maximo 250 caracteres'
        ],
        'id_categoria' => [
            'required' => 'El campo id_categoria es obligatorio',
            'is_natural_no_zero' => 'El campo id_categoria debe contener un numero natural mayor a 0'
        ]
    ];
    protected $skipValidation = false;
    public function CategoriaEntrada($id = null){
        $builder = $this->db->table($this->table);
        $builder ->select('entradas.id AS entradas, entradas.descripcion, entradas.ingredientes, entradas.tiempo_preparacion, entradas.preparacion');
        $builder ->select('receta.id AS recetas, receta.Categoria');
        $builder ->join('receta','entradas.id_categoria = receta.id');
    $builder->where('receta.id',$id);
        $query = $builder->get();
    return $query->getResult();
    }
}