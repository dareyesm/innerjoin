<?php

class Users{
    
    public function __construct() { }
    
    public function log_in(){
        
        require 'database.php';
        $objdata = new Database();
        
        $sth = $objdata->prepare('SELECT * FROM users U inner join profiles P '
                . 'ON U.idProf = P.idProfile '
                . 'WHERE U.logUser = :login AND U.pasUser = :pass');
        
        $sth->execute(array(
            ':login' => $_POST['Usern'],
            ':pass' => $_POST['passU']
        ));
        
        $data = $sth->fetch();
        
        $count = $sth->rowCount();
        
        if($count > 0){
            require 'sessions.php';
            $objSess = new Sessions();
            $objSess->init();
            $objSess->set('login', $data['logUser']);
            $objSess->set('idpro', $data['idProf']);
            $objSess->set('profi', $data['profName']);
            
            switch ($data['profName']){
                case 'Admin':
                    //Borrar desde aquí
                    echo "Has iniciado Sesión como Administrador.";
                    die();
                    //Borrar hasta aquí
                    header('location: ' . URL . 'admin/');
                    break;
                case 'Standard':
                    //Borrar desde aquí
                    echo "Has iniciado Sesión como Usuario Estandar.";
                    die();
                    //Borrar hasta aquí
                    header('location: ' . URL . 'dashboard/');
                    break;
            }
            
        }else{
            header('location: ' . URL . 'index.php?iderr=1');
        }
        
    }
}

