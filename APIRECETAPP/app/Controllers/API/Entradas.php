<?php

namespace App\Controllers\API;

use App\Models\EntradasModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Entradas extends ResourceController{
    public function __construct(){
        $this->model = $this->setModel(new EntradasModel());
    }

    public function index(){
        $entradas = $this->model->findAll();
        return $this->respuesta($entradas,'',200);
    }

    public function show($id=null){
        try {
            if ($id==null){
                return $this->respuesta([],'Debe especificar un id',404);
            } else{
                $entradas = $this->model->find($id);
                if ($entradas==null){
                    return $this->respuesta([],'No existe la entrada con el id especificado',404);
                } else {
                    return $this->respuesta($entradas,'',200);
                }
            }
        }catch(\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function create(){
        try{
            $entradas = $this->request->getJSON();
            $data = [
                'descripcion' => $entradas->descripcion,
                'ingredientes' => $entradas->ingredientes,
                'tiempo_preparacion' => $entradas->tiempo_preparacion,
                'preparacion' => $entradas->preparacion,
                'id_categoria' => $entradas->id_categoria
            ];
            if($this->model->insert($data)){
                $entradas->id = $this->model->insertID();
                return $this->respuesta($entradas,'Operacio exitosa',201);
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
                $entradas = $this->model->find($id);
                if ($entradas==null){
                    return $this->respuesta([],'No existe la entrada con el id especificado',404);
                } else {
                    $entradas = $this->request->getJSON();
                    if ($this->model->update($id, $entradas)){
                        return $this->respuesta($entradas,'',200);
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
                $entradas = $this->model->find($id);
                if ($entradas==null){
                    return $this->respuesta([],'No existe la entrada con el id especificado',404);
                } else {
                    if ($this->model->delete($id)){
                        return $this->respuesta('Operacion exitosa','',200);
                    } else {
                        return $this->respuesta([],'No se pudo eliminar la entrada',500);
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

    public function getEntradasCategorias($id = null)
    {
        try {
            $modelEntradas = new EntradasModel();

            if($id == null)
            return $this->failValidationErrors('No se ha pasadi un Id valido');

            $entrada = $modelEntradas->find($id);

            if($entrada == null)
            return $this->failNotFound('No se ha encontrado una Entrada con el id:' .$id);
        $recetas = $this->model->RecetaModel($id);
        return $this->respond($recetas);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor'); 
        }
    }
}
