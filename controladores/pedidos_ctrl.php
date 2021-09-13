<?php

class pedidos_ctrl {

    public $m_pedido = null;
    public $m_pedido_detalle = null;

    public function __construct(){

        $this->m_pedido = new m_pedidos();
        $this->m_pedido_detalle = new m_pedidos_detalle();

    }
    
    public function crear($f3){

        $this->m_pedido->set('pedido_id', $f3->get('POST.pedido_id'));
        $this->m_pedido->set('fecha', $f3->get('POST.fecha'));
        $this->m_pedido->set('usuario_id', $f3->get('POST.usuario_id'));
        $this->m_pedido->set('estado', $f3->get('POST.estado'));
            echo json_encode([
            'mensaje' => 'Pedido creado',
            'info' => [
                'id' => $this->m_pedido->get('id')
            ]
        ]);
    }

    public function agregar_producto($f3){

        $this->m_pedido->load(['id = ?', $f3->get('PARAMS.pedido_id')]);
        if($this->m_pedido->loaded() > 0){
        $this->m_pedido_detalle->set('pedido_id', $f3->get('PARAMS.pedido_id'));
        $this->m_pedido_detalle->set('producto_id', $f3->get('POST.producto_id'));
        $this->m_pedido_detalle->set('cantidad', $f3->get('POST.cantidad'));
        $this->m_pedido_detalle->set('precio', $f3->get('POST.precio'));
        $this->m_pedido_detalle->save();
        echo json_encode([
            'mensaje' => 'Producto agregado',
            'info' => [
                'id' => $this->m_pedido_detalle->get('id')
            ]
        ]);
        }else{
            echo json_encode([
                'mensaje' => 'El pedido no existe',
                'info' => []
            ]);
        }
    }

    public function consultar($f3){

        $pedido_id = $f3->get('PARAMS.pedido_id');
        $this->m_pedido->load(['id=?', $pedido_id]);
        $msg = "";
        $item = array();
        if($this->m_pedido->loaded() > 0){
            $msg = "Pedido encontrado";
            $item = $this->m_pedido->cast();
        }else{
                $msg = "Pedido no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    public function listado($f3){
        
        $result = $this->m_pedido->find();
        $items = array();
        foreach($result as $pedido){
            $items[] = $pedido->cast();
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

        $pedido_id = $f3->get('POST.pedido_id');
        $this->m_pedido->load(['id=?', $pedido_id]);
        $msg = "";
        $item = array();
        if($this->m_pedido->loaded() > 0){
            $msg = "pedido_id eliminado";
            $this->m_pedido->erase();
        }else{
                $msg = "pedido_id no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}