<?php

class clientes_ctrl {

    public $m_cliente = null;

    public function __construct(){

        $this->m_cliente = new m_clientes();

    }
    
    public function crear($f3){

        
            $this->m_cliente->set('ID_Cliente', $f3->get('POST.ID_Cliente'));
            $this->m_cliente->set('Nombre', $f3->get('POST.Nombre'));
            $this->m_cliente->set('Apellido_P', $f3->get('POST.Apellido_P'));
            $this->m_cliente->set('Apellido_M', $f3->get('POST.Apellido_M'));
            $this->m_cliente->set('Contrato', $f3->get('POST.Contrato'));
            $this->m_cliente->set('Acta_Constitutiva', $f3->get('POST.Acta_Constitutiva'));
            $this->m_cliente->set('Razon_Social', $f3->get('POST.Razon_Social'));
            $this->m_cliente->set('Representante_Legal', $f3->get('POST.Representante_Legal'));
            $this->m_cliente->set('RFC', $f3->get('POST.RFC'));
            $this->m_cliente->set('Direccion_Fiscal', $f3->get('POST.Direccion_Fiscal'));
            $this->m_cliente->set('Direccion_Comercial', $f3->get('POST.Direccion_Comercial'));
            $this->m_cliente->set('Num_cuenta', $f3->get('POST.Num_cuenta'));
            $this->m_cliente->set('Foto', $f3->get('POST.Foto'));

            $this->m_cliente->save();

            echo json_encode([
                'mensaje' => 'Cliente Creado',
                'info' => [
                    'id' => $this->m_cliente->get('ID_Cliente')
                ]
            ]);
    }

    public function consultar($f3){

        $ID_Cliente = $f3->get('POST.ID_Cliente');
        $this->m_cliente->load(['ID_Cliente=?', $ID_Cliente]);
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
        $ID_Cliente = $f3->get('POST.ID_Cliente');
        $this->m_cliente->load(['ID_Cliente=?', $ID_Cliente]);
        $msg = "";
        if($this->m_cliente->loaded() > 0){
            $_cliente = new m_clientes();
            $_cliente->load(['RFC = ? AND ID_CLiente <> ?', $f3->get('POST.RFC'), $ID_Cliente ]);
            if($_cliente->loaded() > 0){
            $msg = " El registro no se pudo modificar debido a que el RFC se encuentra en uso por otro usuario";
            }else{
                $this->m_cliente->set('Nombre', $f3->get('POST.Nombre'));
                $this->m_cliente->set('Apellido_P', $f3->get('POST.Apellido_P'));
                $this->m_cliente->set('Apellido_M', $f3->get('POST.Apellido_M'));
                $this->m_cliente->set('Contrato', $f3->get('POST.Contrato'));
                $this->m_cliente->set('Acta_Constitutiva', $f3->get('POST.Acta_Constitutiva'));
                $this->m_cliente->set('Razon_Social', $f3->get('POST.Razon_Social'));
                $this->m_cliente->set('Representante_Legal', $f3->get('POST.Representante_Legal'));
                $this->m_cliente->set('RFC', $f3->get('POST.RFC'));
                $this->m_cliente->set('Direccion_Fiscal', $f3->get('POST.Direccion_Fiscal'));
                $this->m_cliente->set('Direccion_Comercial', $f3->get('POST.Direccion_Comercial'));
                $this->m_cliente->set('Num_cuenta', $f3->get('POST.Num_cuenta'));
                $this->m_cliente->set('Foto', $f3->get('POST.Foto'));
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
        foreach($result as $ID_Cliente){
            $items[] = $ID_Cliente->cast();
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

        $ID_Cliente = $f3->get('POST.ID_Cliente');
        $this->m_cliente->load(['ID_Cliente=?', $ID_Cliente]);
        $msg = "";
        $item = array();
        if($this->m_cliente->loaded() > 0){
            $msg = "Cliente eliminado";
            $this->m_cliente->erase();
        }else{
                $msg = "Cliente no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}