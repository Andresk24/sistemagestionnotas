<?php

class ConexionBD {

    private $servidor;
    private $puerto;
    private $baseDatos;
    private $controlador;
    private $usuario;
    private $clave;
    private $conexion;

    function __construct() {
        $archivo = dirname(__FILE__) . '/configuracion.ini';
        if (!file_exists($archivo)) {
            echo "Error: No existe el archivo $archivo";
            die();
        }
        if (!$parametros = parse_ini_file($archivo, true)) {
            echo "Error: no se pudo abrir el archivo de configuración $archivo";
            die();
        }
        $this->servidor = $parametros['BaseDatos']['servidor'];
        $this->puerto = $parametros['BaseDatos']['puerto'];
        $this->baseDatos = $parametros['BaseDatos']['baseDatos'];
        $this->controlador = $parametros['BaseDatos']['controlador'];
        $this->usuario = $parametros['BaseDatos']['usuario'];
        $this->clave = $parametros['BaseDatos']['clave'];
    }

    private function getConexion() {
        return $this->conexion;
    }

    private function conectar($bd) {
        try {
            if ($bd == null)
                $bd = $this->baseDatos;
            $opciones = array();
            $this->conexion = new PDO("$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$bd", $this->usuario, $this->clave, $opciones);
        } catch (Exception $exc) {
            $this->conexion = null;
            echo $exc->getMessage();
            die();
        }
    }

    private function desconectar() {
        $this->conexion = null;
    }

    public static function ejecutarQuery($cadenaSQL) {
        $conector = new ConexionBD();
        $conector->conectar(null);
        $sentencia = $conector->getConexion()->prepare($cadenaSQL);

        if (!$sentencia->execute()) {
            throw new Exception("Error al intentar ejecutar la consulta: $cadenaSQL");
        }

        $consulta = $sentencia->fetchAll();
        $sentencia->closeCursor();

        $conector->desconectar();
        return $consulta;
    }

    public static function ejecutarQueryLista($cadenaSQL, $parametros = null) {
        $conector = new ConexionBD();
        $conector->conectar(null);
        $sentencia = $conector->getConexion()->prepare($cadenaSQL);

        // Vincula los parámetros de manera segura si se proporcionan
        if ($parametros) {
            foreach ($parametros as $nombre => $valor) {
                $sentencia->bindValue($nombre, $valor);
            }
        }

        if (!$sentencia->execute()) {
            throw new Exception("Error al intentar ejecutar la consulta: $cadenaSQL");
        }

        $consulta = $sentencia->fetchAll();
        $sentencia->closeCursor();

        $conector->desconectar();
        return $consulta;
    }

    public function ejecutarQueryBD($cadenaSQL, $bd) {
        global $CONTENIDO;
        if (substr($cadenaSQL, 0, 6) != 'select' && $_SESSION['bitacora'] == 2)
            registrarBitacora($_SESSION['usuario']->getUsuario(), ConexionBD::getSuceso($cadenaSQL), $cadenaSQL, $CONTENIDO);
        $conector = new ConexionBD();
        $conector->conectar(strtolower($bd));
        $sentencia = $conector->getConexion()->prepare($cadenaSQL);
        if (!$sentencia->execute())
            return FALSE;
        $consulta = $sentencia->fetchAll();
        $sentencia->closeCursor();
        $conector->desconectar();
        return($consulta);
    }

    public function ejecutarQueryMultipleBD($cadenaSQL, $bd) {
        $cadenasSQL = explode(';', $cadenaSQL);
        $buscar = array("______");
        $reemplazar = array(";");
        $cadenasSQL = str_ireplace($buscar, $reemplazar, $cadenasSQL);
        for ($i = 0; $i < count($cadenasSQL) - 1; $i++) {
            $cadenaSQL = $cadenasSQL[$i];
            ConexionBD::ejecutarQueryBD($cadenaSQL, $bd);
        }
    }

}
