<?php

class patrullajes_ctrl {

    public $m_patrullaje = null;

    public function __construct(){

        $this->m_patrullaje = new m_patrullajes();

    }
    
    public function crear($f3){

        
            $this->m_patrullaje->set('Patrullaje', $f3->get('POST.Patrullaje'));
            $this->m_patrullaje->set('Fecha', $f3->get('POST.Fecha'));
            $this->m_patrullaje->set('Nombre_Punto', $f3->get('POST.Nombre_Punto'));
            $this->m_patrullaje->set('Hora_Inicio', $f3->get('POST.Hora_Inicio'));
            $this->m_patrullaje->set('Hora_Termino', $f3->get('POST.Hora_Termino'));
            $this->m_patrullaje->set('Observaciones', $f3->get('POST.Observaciones'));
            $this->m_patrullaje->set('Codigo_QR', $f3->get('POST.Codigo_QR'));
            $this->m_patrullaje->set('ClaveEmpleado', $f3->get('POST.ClaveEmpleado'));
            $this->m_patrullaje->save();

            echo json_encode([
                'mensaje' => 'Patrullaje Creado',
                'info' => [
                    'id' => $this->m_patrullaje->get('Patrullaje')
                ]
            ]);
    }

    public function consultar($f3){

        $Patrullaje = $f3->get('POST.Patrullaje');
        $this->m_patrullaje->load(['Patrullaje=?', $Patrullaje]);
        $msg = "";
        $item = array();
        if($this->m_patrullaje->loaded() > 0){
            $msg = "Patrullaje encontrado";
            $item = $this->m_patrullaje->cast();
        }else{
                $msg = "Patrullaje no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    public function actualizar($f3){
        $Patrullaje = $f3->get('POST.Patrullaje');
        $this->m_patrullaje->load(['Patrullaje=?', $Patrullaje]);
        $msg = "";
        if($this->m_patrullaje->loaded() > 0){
            
            $this->m_patrullaje->set('Fecha', $f3->get('POST.Fecha'));
            $this->m_patrullaje->set('Nombre_Punto', $f3->get('POST.Nombre_Punto'));
            $this->m_patrullaje->set('Hora_Inicio', $f3->get('POST.Hora_inicio'));
            $this->m_patrullaje->set('Hora_Termino', $f3->get('POST.Hora_Termino'));
            $this->m_patrullaje->set('Observaciones', $f3->get('POST.Observaciones'));
            $this->m_patrullaje->set('Codigo_QR', $f3->get('POST.Codigo_QR'));
            $this->m_patrullaje->set('ClaveEmpleado', $f3->get('POST.ClaveEmpleado'));
            $this->m_patrullaje->save();
            $msg = 'Registro Actualizado';
                 }
        else{
            $msg = " El registro no existe";

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => []
        ]);
    }
    
    public function listado($f3){
        
        $result = $this->m_patrullaje->find();
        $items = array();
        foreach($result as $Patrullaje){
            $items[] = $Patrullaje->cast();
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

        $Patrullaje = $f3->get('POST.Patrullaje');
        $this->m_patrullaje->load(['Patrullaje=?', $Patrullaje]);
        $msg = "";
        $item = array();
        if($this->m_patrullaje->loaded() > 0){
            $msg = "Patrullaje eliminado";
            $this->m_patrullaje->erase();
        }else{
                $msg = "Patrullaje no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}