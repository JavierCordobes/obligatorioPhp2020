<?php

abstract class Persona{
    
    private $cedula;
    private $nombres;
    private $apellido;
    private $pin;
    private $foto;
    private $eliminado;

    function __construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado){

        $this->cedula = $cedula;
        $this->nombres = $nombres;
        $this->apellido = $apellido;
        $this->pin = $pin;
        $this->foto = $foto;
        $this->eliminado = '0';

    }

}

class Encargado extends Persona{

    private $email;

    function __construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado, $email){

        parent::__construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado);
        $this->email = $email;
    }

    function agregar($conexion, $cedula, $nombres, $apellidos, $pin, $foto, $email){

        $consulta = mysqli_query($conexion, "INSERT INTO encargado(cedula, nombres, apellidos, email, foto, pin) VALUES ('$cedula', '$nombres', '$apellidos', '$email', '$foto', '$pin')");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj ok'>El encargado se agrego exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=1'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function modificar($conexion, $cedulaEncargado, $cedulaNueva, $nombres, $apellidos, $pin, $foto, $email){

        $consulta = mysqli_query($conexion, "UPDATE encargado SET cedula = '$cedulaNueva', nombres = '$nombres', apellidos = '$apellidos', email = '$email', foto = '$foto' WHERE cedula = '$cedulaEncargado' AND eliminado = '0'");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj alerta'>El encargado se actualizo exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=1'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function eliminar($conexion, $cedulaEncargado){
        
        $consulta = mysqli_query($conexion, "UPDATE encargado SET eliminado = '1' WHERE cedula = '$cedulaEncargado' AND eliminado = '0'");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj alerta'>El encargado se elimino exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=2'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }
}

class Transportista extends Persona{

    private $direccion;
    private $telefono;

    function __construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado, $direccion, $telefono){
        
        parent::__construct($cedula, $nombres, $apellidos, $pin, $foto, $eliminado);
        $this->direccion = $direccion;
        $this->telefono = $telefono;

    }

    function seteoDatos($cedula, $nombres, $apellidos, $pin, $foto, $eliminado, $direccion, $telefono){

        $this->cedula = $cedula;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->pin = $pin;
        $this->foto = $foto;
        $this->eliminado = $eliminado;
        $this->direccion = $direccion;
        $this->telefono = $telefono;

    }

    function agregar(){

        $consulta = mysqli_query($conexion, "INSERT INTO transportista(cedula, nombres, apellidos, direccion, telefono, foto, pin) VALUES ('$this->cedula', '$this->nombres', '$this->apellidos', '$this->direccion', '$this->telefono', '$this->foto', '$this->pin')");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj ok'>El transportista se agrego exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=3'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function modificar($conexion, $cedulaTransportista, $cedulaNueva, $nombres, $apellidos, $pin, $foto, $telefono, $direccion){

        $consulta = mysqli_query($conexion, "UPDATE transportista SET cedula = '$cedulaNueva', nombres = '$nombres', apellidos = '$apellidos', direccion = '$direccion', telefono = '$telefono', foto = '$foto' WHERE cedula = '$cedulaTransportista' AND eliminado = '0'");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj alerta'>El transportista se actualizo exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=3'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function eliminar($conexion, $cedulaTransportista){
        
        $consulta = mysqli_query($conexion, "UPDATE transportista SET eliminado = '1' WHERE cedula = '$cedulaTransportista' AND eliminado = '0'");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj alerta'>El transportista se elimino exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=2'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

}


?>