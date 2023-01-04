<?php

namespace App\Controllers\API;

use App\Models\RecetaModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Receta extends ResourceController{
    public function __construct(){
        $this->model = $this->setModel(new RecetaModel());
    }

    public function index(){
        $receta = $this->model->findAll();
        return $this->respuesta($receta,'',200);
    }

    public function show($id = null){
        try {
            if ($id==null){
                return $this->respuesta([],'Debe especificar un id',404);
            } else{
                $receta = $this->model->find($id);
                if ($receta==null){
                    return $this->respuesta([],'No existe la receta con el id especificado',404);
                } else {
                    return $this->respuesta($receta,'',200);
                }
            }
        }catch(\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function create(){
        try{
            $receta = $this->request->getJSON();
            $data = [
                'Categoria' => $receta->Categoria,
            ];
            if($this->model->insert($data)){
                $receta->id = $this->model->insertID();
                return $this->respuesta($receta,'Operacio exitosa',201);
            }
        } catch (Exception $e){
            return $this->respuesta([], $e->getMessage(),500);
        }
    }

    public function update($id = null){
        try{
            if ($id==null){
                return $this->respuesta([],'Debe especificar el id',404);
            }else {
                $receta = $this->model->find($id);
                if ($receta==null){
                    return $this->respuesta([],'No existe la receta con el id especificado',404);
                } else {
                    $receta = $this->request->getJSON();
                    if ($this->model->update($id, $receta)){
                        return $this->respuesta($receta,'',200);
                    } else {
                        return $this->failValidationErrors($this->model->validation->listErrors());
                    }
                } 
            }
        } catch (\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function delete($id = null){
        try{
            if ($id==null){
                return $this->respuesta([],'Debe especificar un id',404);
            } else {
                $receta = $this->model->find($id);
                if ($receta==null){
                    return $this->respuesta([],'No existe la receta con el id especificado',404);
                } else {
                    if ($this->model->delete($id)){
                        return $this->respuesta('Operacion exitosa','',200);
                    } else {
                        return $this->respuesta([],'No se pudo eliminar la receta',500);
                    }
                }
            }
        } catch (\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function respuesta($data, $mensaje, $codigo){
        if ($codigo == 200){
            return $this->respond(
                array(
                    "status" => $codigo,
                    "data" => $data,
                )
            );
        }else {
            return $this->respond(
                array(
                    "status" => $codigo,
                    "data" => $mensaje,
                )
            );
        }
    }
}