<?php

class productos_ctrl {

    public $m_producto = null;

    public function __construct(){

        $this->m_producto = new m_productos();

    }
    
    public function crear($f3){

        $this->m_producto->set('codigo', $f3->get('POST.codigo'));
        $this->m_producto->set('codigo', $f3->get('POST.codigo'));
        $this->m_producto->set('stock', $f3->get('POST.stock'));
        $this->m_producto->set('precio', $f3->get('POST.precio'));
        $this->m_producto->set('activo', $f3->get('POST.activo'));
        $this->m_producto->save();
         echo json_encode([
            'mensaje' => 'Producto creado',
            'info' => [
                'id' => $this->m_producto->get('id')
            ]
        ]);
    }
    public function actualizar($f3){
        $producto_id = $f3->get('PARAMS.producto_id');
        $this->m_producto->load(['id=?', $producto_id]);
        $msg = "";
        if($this->m_producto->loaded() > 0){
            $_pedido = new m_productos();
            $_pedido->load(['codigo = ? AND id <> ?', $f3->get('POST.codigo'), $producto_id ]);
            if($_pedido->loaded() > 0){
            $msg = " El registro no se pudo modificar debido a que el codigose encuentra en uso ";
            }else{
            $this->m_producto->set('codigo', $f3->get('POST.codigo'));
            $this->m_producto->set('nombre', $f3->get('POST.nombre'));
            $this->m_producto->set('stock', $f3->get('POST.stock'));
            $this->m_producto->set('precio', $f3->get('POST.precio'));
            $this->m_producto->set('activo', $f3->get('POST.activo'));
            $this->m_producto->save();
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

    public function consultar($f3){

        $producto_id = $f3->get('PARAMS.producto_id');
        $this->m_producto->load(['id=?', $producto_id]);
        $msg = "";
        $item = array();
        if($this->m_producto->loaded() > 0){
            $msg = "Producto encontrado";
            $item = $this->m_producto->cast();
        }else{
                $msg = "Producto no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    public function listado($f3){
        
        $result = $this->m_producto->find();
        $items = array();
        foreach($result as $producto){
            $items[] = $producto->cast();
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

        $producto_id = $f3->get('POST.producto_id');
        $this->m_producto->load(['id=?', $producto_id]);
        $msg = "";
        $item = array();
        if($this->m_producto->loaded() > 0){
            $msg = "Producto eliminado";
            $this->m_producto->erase();
        }else{
                $msg = "Producto no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
}