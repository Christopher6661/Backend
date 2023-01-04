<?php

namespace App\Controllers\API;

use App\Models\PostresModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Postres extends ResourceController{
    public function __construct(){
        $this->model = $this->setModel(new PostresModel());
    }

    public function index(){
        $postres = $this->model->findAll();
        return $this->respuesta($postres,'',200);
    }

    public function show($id=null){
        try {
            if ($id==null){
                return $this->respuesta([],'Debe especificar un id',404);
            } else{
                $postres = $this->model->find($id);
                if ($postres==null){
                    return $this->respuesta([],'No existe el postre con el id especificado',404);
                } else {
                    return $this->respuesta($postres,'',200);
                }
            }
        }catch(\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function create(){
        try{
            $postres = $this->request->getJSON();
            $data = [
                'descripcion' => $postres->descripcion,
                'ingredientes' => $postres->ingredientes,
                'tiempo_preparacion' => $postres->tiempo_preparacion,
                'preparacion' => $postres->preparacion,
                'id_categoria' => $postres->id_categoria
            ];
            if($this->model->insert($data)){
                $postres->id = $this->model->insertID();
                return $this->respuesta($postres,'Operacio exitosa',201);
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
                $postres = $this->model->find($id);
                if ($postres==null){
                    return $this->respuesta([],'No existe el postre con el id especificado',404);
                } else {
                    $postres = $this->request->getJSON();
                    if ($this->model->update($id, $postres)){
                        return $this->respuesta($postres,'',200);
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
                $postres = $this->model->find($id);
                if ($postres==null){
                    return $this->respuesta([],'No existe el postre con el id especificado',404);
                } else {
                    if ($this->model->delete($id)){
                        return $this->respuesta('Operacion exitosa','',200);
                    } else {
                        return $this->respuesta([],'No se pudo eliminar el postre',500);
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