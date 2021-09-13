<?php

class clientes_ctrl {

    public $m_cliente = null;

    public function __construct(){

        $this->m_cliente = new m_clientes();

    }
    
    public function crear($f3){

        $this->m_cliente->load(['identificacion = ? OR correo = ?', $f3->get('POST.identificacion'), $f3->get('POST.correo')]);
        if($this->m_cliente->loaded() > 0){

            echo json_encode([
                'mensaje' => 'Ya existe el cliente que intenta crear.',
                'info' => [
                    'id' => 0
                ]
            ]);
            
        }else{
            $this->m_cliente->set('identificacion', $f3->get('POST.identificacion'));
            $this->m_cliente->set('nombre', $f3->get('POST.nombre'));
            $this->m_cliente->set('telefono', $f3->get('POST.telefono'));
            $this->m_cliente->set('correo', $f3->get('POST.correo'));
            $this->m_cliente->set('direccion', $f3->get('POST.direccion'));
            $this->m_cliente->set('pais', $f3->get('POST.pais'));
            $this->m_cliente->set('ciudad', $f3->get('POST.ciudad'));
            $this->m_cliente->save();

            echo json_encode([
                'mensaje' => 'Cliente Creado',
                'info' => [
                    'id' => $this->m_cliente->get('id')
                ]
            ]);
             

        }

       
    }

    public function consultar($f3){

        $cliente_id = $f3->get('PARAMS.cliente_id');
        $this->m_cliente->load(['id=?', $cliente_id]);
        $msg = "";
        $item = array();
        if($this->m_cliente->loaded() > 0){
            $msg = "Cliente encontrado";
            $item = $this->m_cliente->cast();
        }else{
                $msg = "Cliente no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    public function actualizar($f3){
        $cliente_id = $f3->get('PARAMS.cliente_id');
        $this->m_cliente->load(['id=?', $cliente_id]);
        $msg = "";
        if($this->m_cliente->loaded() > 0){
            $_cliente = new m_clientes();
            $_cliente->load(['correo = ? AND id <> ?', $f3->get('POST.correo'), $cliente_id ]);
            if($_cliente->loaded() > 0){
            $msg = " El registro no se pudo modificar debido a que el correo se encuentra en uso por otro usuario";
            }else{
            $this->m_cliente->set('nombre', $f3->get('POST.nombre'));
            $this->m_cliente->set('telefono', $f3->get('POST.telefono'));
            $this->m_cliente->set('direccion', $f3->get('POST.direccion'));
            $this->m_cliente->set('pais', $f3->get('POST.pais'));
            $this->m_cliente->set('ciudad', $f3->get('POST.ciudad'));
            $this->m_cliente->set('correo', $f3->get('POST.correo'));
            $this->m_cliente->save();
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
        
        $result = $this->m_cliente->find();
        $items = array();
        foreach($result as $cliente_id){
            $items[] = $cliente_id->cast();
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

        $cliente_id = $f3->get('POST.cliente_id');
        $this->m_cliente->load(['id=?', $cliente_id]);
        $msg = "";
        $item = array();
        if($this->m_cliente->loaded() > 0){
            $msg = "cliente_id eliminado";
            $this->m_cliente->erase();
        }else{
                $msg = "cliente_id no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}