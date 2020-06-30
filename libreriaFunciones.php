<?php

    //Esto lo comente porque me dio paja crear el objeto, despues lo hacemos igual jajaja
    //class conexionSQL {

        function conectarSQL($ip = "localhost", $user = "root", $pass = ""){

            return mysqli_connect($ip, $user, $pass);
        }

        function conectarBD($conexion, $bd){

            return mysqli_select_db($conexion, $bd);

        }
        
        function cerrarConexion($conexion){

            mysqli_close($conexion);
        }


  //  }

    function ingreso($CI, $PIN, $conexion, $tipo){


        if($tipo == "en"){

            $resultado = mysqli_query($conexion, "SELECT cedula, pin FROM encargado WHERE cedula = $CI");
            
            if($resultado){

                $filaAsociativa = mysqli_fetch_array($resultado);
    
                $ciBD = $filaAsociativa["cedula"];
                $pinBD = $filaAsociativa["pin"];

                if($PIN == $pinBD){

                    cerrarConexion($conexion);
                    header("Location: inicio.php?type=en&ci=$ciBD");
                    die();
                } else {

                    echo "Cedula y PIN no coinciden, pruebe nuevamente.";
                }
            } else {

                echo "Cedula y PIN no coinciden, pruebe nuevamente.";
            }

        } else if($tipo == "tr"){

            $resultado = mysqli_query($conexion, "SELECT cedula, pin FROM transportista WHERE cedula = $CI");
                
            if($resultado){

                $filaAsociativa = mysqli_fetch_array($resultado);

                $ciBD = $filaAsociativa["cedula"];
                $pinBD = $filaAsociativa["pin"];

                if($PIN == $pinBD){

                    cerrarConexion($conexion);
                    header("Location: inicio.php?type=tr&ci=$ciBD");
                    die();
                } else {

                    echo "Cedula y PIN no coinciden, pruebe nuevamente.";
                } 
            } else {

                echo "Cedula y PIN no coinciden, pruebe nuevamente.";
            }

        } else if($tipo == "vs"){

            cerrarConexion($conexion);
            header("Location: inicio.php?type=vs");
            die();
        } else {

            //Podriamos hace una pagina de error para que cuando pase algo asi redirigir con un dato clave para ver el tipo de error y notificar
            echo "Mostrar mensaje de error";
        }
    }

    function buscarNombre($ci, $tipo){

        if($tipo == "en"){
            $tabla = "encargado";

        } else if($tipo == "tr") {
            $tabla = "transportista";

        } else {
            echo "mensaje de error";
            die();
        }

        $conexion = conectarSQL();
        if(!$conexion)
          die("Error en la conexion al servidor");

        $conexionBD = conectarBD($conexion, "Obligatorio");
        if(!$conexionBD)
          die("Error en la conexion a la base de datos");

        $resultado = mysqli_query($conexion, "SELECT nombres FROM $tabla WHERE cedula = $ci");
            
        if($resultado){

            $filaAsociativa = mysqli_fetch_array($resultado);

            $nomBD = $filaAsociativa["nombres"];

            return $nomBD;

        } else {

            echo "Ocurrio un error en la consulta.";
        }

    }


?>