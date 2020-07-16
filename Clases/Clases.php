<?php

abstract class Persona{
    
    private $cedula;
    private $nombres;
    private $apellido;
    private $foto;
    private $eliminado;

}

class Encargado extends Persona{

    private $email;

    function seteoDatos($cedula, $nombres, $apellidos, $foto, $email){

        $this->cedula = $cedula;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->foto = $foto;
        $this->email = $email;

    }

    function agregar($conexion, $pin){

        $pinMD5 = md5($pin);
        $consulta = mysqli_query($conexion, "INSERT INTO encargado(cedula, nombres, apellidos, email, foto, pin) VALUES ('$this->cedula', '$this->nombres', '$this->apellidos', '$this->email', '$this->foto', '$pinMD5')");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj ok'>El encargado se agrego exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=3'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function modificar($conexion, $cedulaEncargado){

        $consulta = mysqli_query($conexion, "UPDATE encargado SET cedula = '$this->cedula', nombres = '$this->nombres', apellidos = '$this->apellidos', email = '$this->email', foto = '$this->foto' WHERE cedula = '$cedulaEncargado' AND eliminado = '0'");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj alerta'>El encargado se actualizo exitosamente</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=3'>";
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

    function seteoDatos($cedula, $nombres, $apellidos, $foto, $direccion, $telefono){

        $this->cedula = $cedula;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->foto = $foto;
        $this->direccion = $direccion;
        $this->telefono = $telefono;

    }

    function agregar($conexion, $pin){

        $pinMD5 = md5($pin);
        $consulta = mysqli_query($conexion, "INSERT INTO transportista(cedula, nombres, apellidos, direccion, telefono, foto, pin) VALUES ('$this->cedula', '$this->nombres', '$this->apellidos', '$this->direccion', '$this->telefono', '$this->foto', '$pinMD5')");

        if($consulta){

            cerrarConexion($conexion);
            echo "<div class='msj ok'>El transportista se agrego exitosamente, pin = $pinMD5</div>";
            echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=3'>";
            die();
        } else {
            echo "<div class='msj error'>Ocurrio un error en la consulta</div>";
        }
        cerrarConexion($conexion);
    }

    function modificar($conexion, $cedulaTransportista){

        $consulta = mysqli_query($conexion, "UPDATE transportista SET cedula = '$this->cedula', nombres = '$this->nombres', apellidos = '$this->apellidos', direccion = '$this->direccion', telefono = '$this->telefono', foto = '$this->foto' WHERE cedula = '$cedulaTransportista' AND eliminado = '0'");

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
}


?>