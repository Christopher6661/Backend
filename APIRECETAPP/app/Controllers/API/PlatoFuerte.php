<?php

namespace App\Controllers\API;

use App\Models\PlatoFuerteModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class PlatoFuerte extends ResourceController{
    public function __construct(){
        $this->model = $this->setModel(new PlatoFuerteModel());
    }

    public function index(){
        $platofuerte = $this->model->findAll();
        return $this->respuesta($platofuerte,'',200);
    }

    public function show($id=null){
        try {
            if ($id==null){
                return $this->respuesta([],'Debe especificar un id',404);
            } else{
                $platofuerte = $this->model->find($id);
                if ($platofuerte==null){
                    return $this->respuesta([],'No existe el plato fuerte con el id especificado',404);
                } else {
                    return $this->respuesta($platofuerte,'',200);
                }
            }
        }catch(\Exception $e){
            return $this->respuesta([],$e->getMessage(),500);
        }
    }

    public function create(){
        try{
            $platofuerte = $this->request->getJSON();
            $data = [
                'descripcion' => $platofuerte->descripcion,
                'ingredientes' => $platofuerte->ingredientes,
                'tiempo_preparacion' => $platofuerte->tiempo_preparacion,
                'preparacion' => $platofuerte->preparacion,
                'id_categoria' => $platofuerte->id_categoria
            ];
            if($this->model->insert($data)){
                $platofuerte->id = $this->model->insertID();
                return $this->respuesta($platofuerte,'Operacio exitosa',201);
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
                $platofuerte = $this->model->find($id);
                if ($platofuerte==null){
                    return $this->respuesta([],'No existe el plato fuerte con el id especificado',404);
                } else {
                    $platofuerte = $this->request->getJSON();
                    if ($this->model->update($id, $platofuerte)){
                        return $this->respuesta($platofuerte,'',200);
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
                $platofuerte = $this->model->find($id);
                if ($platofuerte==null){
                    return $this->respuesta([],'No existe el plato fuerte con el id especificado',404);
                } else {
                    if ($this->model->delete($id)){
                        return $this->respuesta('Operacion exitosa','',200);
                    } else {
                        return $this->respuesta([],'No se pudo eliminar el plato fuerte',500);
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