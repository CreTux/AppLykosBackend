<?php

class logging_ctrl {

    public $m_usuario = null;

    public function __construct(){

        $this->m_usuario = new m_usuarios();

    }
    
    public function login($f3){
      
        $mapper = $this->m_usuario;
        $user = $f3->get('POST.username');
        $pwd = $f3->get('POST.password');
        
                     
        $auth = new Auth($mapper, array('id'=> 'usuario', 'pw'=> 'password'));
        $login_result = $auth->login($user, $pwd); 

        if ($login_result){
            echo json_encode([
            'msg' => 'Autenticacion correcta',
            'results' => $login_result,
            'perfil' => $this->m_usuario->get('perfil')
                ]);
             }       
        else{
            echo json_encode([
                'msg' => 'Autenticacion incorrecta',
                ]);}
  
    }
}
*/

