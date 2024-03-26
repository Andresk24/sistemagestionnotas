<?php

class Usuario {

    private $Id;
    private $Usuario;
    private $Password;
    private $Tipo_usuario;
    
    function __construct($campo, $valor) {
        if ($campo != null) {
            $cadenaSQL = "select Id,usuario,password,tipo_usuario from usuario where  $campo='$valor'";
            $resultado = ConexionBD::ejecutarQuery($cadenaSQL);
            if (count($resultado) > 0) {
                $this->Usuario = $resultado[0]['usuario'];
                $this->Password = $resultado[0]['password'];
                $this->tipo_usuario = $resultado[0]['tipo_usuario'];
            }
        }
    }

    public function getId() {
        return $this->Id;
    }

    public function getUsuario() {
        return $this->Usuario;
    }

    public function getPassword() {
        return $this->Password;
    }

    public function getTipo_usuario() {
        return $this->Tipo_usuario;
    }

    public function setId($Id): void {
        $this->Id = $Id;
    }

    public function setUsuario($Usuario): void {
        $this->Usuario = $Usuario;
    }

    public function setPassword($Password): void {
        $this->Password = $Password;
    }

    public function setTipo_usuario($Tipo_usuario): void {
        $this->Tipo_usuario = $Tipo_usuario;
    }

       

    public function validar($clave) {
        if ($this->Usuario != null && ($clave) == ($this->Password)) {
            return true;
        } else
            return false;
    }

    public static function getLista($filtro) {
        if ($filtro != null)
            $filtro = " where $filtro";
        $cadenaSQL = "select Id,usuario,password,tipo_usuario from usuario  $filtro";
        return ConexionBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro) {
        $lista = array();
        $resultado = Usuario::getLista($filtro);
        for ($i = 0; $i < count($resultado); $i++) {
            $lista[$i] = new Usuario(null, null);
            $lista[$i]->setId($resultado[$i]['id']);
            $lista[$i]->setUsuario($resultado[$i]['usuario']);
            $lista[$i]->setPassword($resultado[$i]['password']);
            $lista[$i]->setTipo_usuario($resultado[$i]['tipo_usuario']);
           
        }
        return $lista;
    }

    public function grabarUsuario() {
        $cadenaSQL = "INSERT INTO usuarios(fecha,nombres, apellidos,usuario,clave,tipouser,activo) VALUES ('$this->Fecha','$this->Nombres','$this->Apellidos','$this->Usuario','$this->Clave','$this->Tipouser',$this->Activo); INSERT INTO permisos (Usuarios,Modulos) VALUES (LAST_INSERT_ID(),1);";
        ConexionBD::ejecutarQuery($cadenaSQL);
    }
   
    
    public function grabarCuenta() {
        $cadenaSQL = "insert into registro (email,password,adminUser,cuenta,fechaRegistro) values ('$this->Email','$this->Password','$this->adminUser','$this->Cuenta','$this->FechaRegistro')";
        ConexionBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($cedula) {
        $cadenaSQL = "update registro set Cuenta='$this->Cuenta' where identity_card=$cedula";
        ConexionBD::ejecutarQuery($cadenaSQL);
    }

    public function modificarTodo($idusuario) {
        $cadenaSQL = "UPDATE usuarios SET nombres='$this->Nombres',apellidos='$this->Apellidos',usuario='$this->Usuario',clave='$this->Clave',tipouser='$this->Tipouser',activo=$this->Activo where idusuario=$idusuario";
        ConexionBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "DELETE usuarios, permisos FROM usuarios JOIN permisos ON usuarios.idusuario = permisos.Usuarios WHERE usuarios.idusuario = $this->Idusuario";
        ConexionBD::ejecutarQuery($cadenaSQL);
    }

}
