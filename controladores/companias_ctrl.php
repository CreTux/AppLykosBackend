<?php

class companias_ctrl {

    public $m_compania = null;

    public function __construct(){

        $this->m_compania = new m_companias();

    }
    

    
    public function crear($f3){

        
            $this->m_compania->set('Compania', $f3->get('POST.Compania'));
            $this->m_compania->set('Nombre', $f3->get('POST.Nombre'));
            $this->m_compania->set('Direccion', $f3->get('POST.Direccion'));
            $this->m_compania->save();

            echo json_encode([
                'mensaje' => 'Compañia Creada',
                'info' => [
                    'id' => $this->m_compania->get('Compania')
                ]
            ]);
    }

    
    public function consultar($f3){

        $compania = $f3->get('POST.Compania');
        $this->m_compania->load(['Compania=?', $compania]);
        $msg = "";
        $item = array();
        if($this->m_compania->loaded() > 0){
            $msg = "Compañia encontrada";
            $item = $this->m_compania->cast();
        }else{
                $msg = "Compania no encontrada";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    
    public function actualizar($f3){
        $compania = $f3->get('POST.Compania');
        $this->m_compania->load(['Compania=?', $compania]);
        $msg = "";
        if($this->m_compania->loaded() > 0){
            $_compania = new m_companias();
            $_compania->load(['Nombre = ? AND Compania <> ?', $f3->get('POST.Nombre'), $compania ]);
            if($_compania->loaded() > 0){
            $msg = " El registro no se pudo modificar debido a que el Nombre se encuentra en uso por otro usuario";
            }else{
            $this->m_compania->set('Nombre', $f3->get('POST.Nombre'));
            $this->m_compania->set('Direccion', $f3->get('POST.Direccion'));
            $this->m_compania->save();
            $msg = 'Registro Actualizado';
                 }
        }else{
            $msg = " El registro no existe";

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => []
        ]);
    }
    

    
    public function listado($f3){
        
        $result = $this->m_compania->find();
        $items = array();
        foreach($result as $compania){
            $items[] = $compania->cast();
        }
        echo json_encode([
            'mensaje' => count($items) > 0 ? '' : 'Aun no hay registros que mostrar.',
            'info' => [
                'items' => $items,
                'total' => count($items)
            ]
        ]);
    }

    
    public function eliminar($f3){

        $compania = $f3->get('POST.Compania');
        $this->m_compania->load(['Compania=?', $compania]);
        $msg = "";
        $item = array();
        if($this->m_compania->loaded() > 0){
            $msg = "Compañia eliminado";
            $this->m_compania->erase();
        }else{
                $msg = "Comapañia no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}