<?php

class contratistas_ctrl {

    public $m_contratista = null;

    public function __construct(){

        $this->m_contratista = new m_contratistas();

    }
    
    public function crear($f3){

        
            $this->m_contratista->set('ClaveContratista', $f3->get('POST.ClaveContratista'));
            $this->m_contratista->set('Fecha', $f3->get('POST.Fecha'));
            $this->m_contratista->set('Nombre', $f3->get('POST.Nombre'));
            $this->m_contratista->set('Apellido_P', $f3->get('POST.Apellido_P'));
            $this->m_contratista->set('Apellido_M', $f3->get('POST.Apellido_M'));
            $this->m_contratista->set('Responsable', $f3->get('POST.Responsable'));
            $this->m_contratista->set('Actividad', $f3->get('POST.Actividad'));
            $this->m_contratista->set('Lugar_Trabajo', $f3->get('POST.Lugar_Trabajo'));
            $this->m_contratista->set('Quien_Contrato', $f3->get('POST.Quien_Contrato'));
            $this->m_contratista->set('Foto', $f3->get('POST.Foto'));
            $this->m_contratista->set('Compania', $f3->get('POST.Compania'));
            $this->m_contratista->save();

            echo json_encode([
                'mensaje' => 'Contratista Creado',
                'info' => [
                    'id' => $this->m_contratista->get('ClaveContratista')
                ]
            ]);
    }

    public function consultar($f3){

        $ClaveContratista = $f3->get('POST.ClaveContratista');
        $this->m_contratista->load(['ClaveContratista=?', $ClaveContratista]);
        $msg = "";
        $item = array();
        if($this->m_contratista->loaded() > 0){
            $msg = "Contratista encontrado";
            $item = $this->m_contratista->cast();
        }else{
                $msg = "Contratista no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);

    }

    public function actualizar($f3){
        $ClaveContratista = $f3->get('POST.ClaveContratista');
        $this->m_contratista->load(['ClaveContratista=?', $ClaveContratista]);
        $msg = "";
        if($this->m_contratista->loaded() > 0){
                $this->m_contratista->set('Fecha', $f3->get('POST.Fecha'));
                $this->m_contratista->set('Nombre', $f3->get('POST.Nombre'));
                $this->m_contratista->set('Apellido_P', $f3->get('POST.Apellido_P'));
                $this->m_contratista->set('Apellido_M', $f3->get('POST.Apellido_M'));
                $this->m_contratista->set('Responsable', $f3->get('POST.Responsable'));
                $this->m_contratista->set('Actividad', $f3->get('POST.Actividad'));
                $this->m_contratista->set('Lugar_Trabajo', $f3->get('POST.Lugar_Trabajo'));
                $this->m_contratista->set('Quien_Contrato', $f3->get('POST.Quien_Contrato'));
                $this->m_contratista->set('Foto', $f3->get('POST.Foto'));
                $this->m_contratista->set('Compania', $f3->get('POST.Compania'));
                $this->m_contratista->save();
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
        
        $result = $this->m_contratista->find();
        $items = array();
        foreach($result as $ClaveContratista){
            $items[] = $ClaveContratista->cast();
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

        $ClaveContratista = $f3->get('POST.ClaveContratista');
        $this->m_contratista->load(['ClaveContratista=?', $ClaveContratista]);
        $msg = "";
        $item = array();
        if($this->m_contratista->loaded() > 0){
            $msg = "Contratista eliminado";
            $this->m_contratista->erase();
        }else{
                $msg = "Contratista no encontrado";
        }
        echo json_encode([
            'mensaje' => $msg,
            'info' => [ ]
        ]);

    }
    
}