<?php

class usuarios_ctrl {

    public $m_usuario = null;

    public function __construct(){

        $this->m_usuario = new m_usuarios();

    }
    
     public function crear($f3){

        $this->m_usuario->set('usuario', $f3->get('POST.usuario'));
        $this->m_usuario->set('clave', $f3->get('POST.clave'));
        $this->m_usuario->set('nombre', $f3->get('POST.nombre'));
        $this->m_usuario->set('telefono', $f3->get('POST.telefono'));
        $this->m_usuario->set('correo', $f3->get('POST.correo'));
        $this->m_usuario->set('activo', $f3->get('POST.activo'));
        $this->m_usuario->set('password', $f3->get('POST.password'));
        $this->m_usuario->set('perfil', $f3->get('POST.perfil'));
        $this->m_usuario->save();
         echo json_encode([
            'mensaje' => 'Usuario creado creado',
            'info' => [
                'id' => $this->m_usuario->get('id')
            ]
        ]);
    }

    public function consultar($f3){

        $pedido_id = $f3->get('PARAMS.pedido_id');
        $this->m_usuario->load(['id=?', $pedido_id]);
        $msg = "";
        $item = array();
        if($this->m_usuario->loaded() > 0){
            $msg = "Pedido encontrado";
            $item = $this->m_usuario->cast();
        }else{
                $msg = "Pedido no encontrado";

        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

        }
    }

    public function actualizar($f3)
    {
        $usuario_id = $f3->get('PARAMS.usuario_id');
        $this->m_usuario->load(['id = ?', $usuario_id]);
        $msg = "";
        if ($this->m_usuario->loaded() > 0) {
            $_usuario = new m_usuarios();
            $_usuario->load(['(usuario = ? OR correo = ?) AND id <> ?', $f3->get('POST.usuario'), $f3->get('POST.correo'), $usuario_id]);
            if ($_usuario->loaded() > 0) {
                $msg = "El registro no se pudo modificar debido a que el nombre usuario o correo se encuentra uso por otro usuario.";
            } else {
                $this->m_usuario->set('usuario', $f3->get('POST.usuario'));
                $this->m_usuario->set('clave', $f3->get('POST.clave'));
                $this->m_usuario->set('nombre', $f3->get('POST.nombre'));
                $this->m_usuario->set('telefono', $f3->get('POST.telefono'));
                $this->m_usuario->set('correo', $f3->get('POST.correo'));
                $this->m_usuario->set('activo', $f3->get('POST.activo'));
                $this->m_usuario->save();
                $msg = "Producto actualizado.";
            }
        } else {
            $msg = "El Producto no existe.";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => []
        ]);
    }

    public function listado($f3){
        
        $result = $this->m_usuario->find();
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

        $cliente_id = $f3->get('POST.pedido_id');
        $this->m_usuario->load(['id=?', $cliente_id]);
        $msg = "";
        $item = array();
        if($this->m_usuario->loaded() > 0){
            $msg = "pedido_id eliminado";
            $this->m_usuario->erase();
        }else{
                $msg = "pedido_id no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }

    
}