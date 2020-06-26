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
                    header("Location: inicio.php?type=en");
                    die();
                }
            }
        } else if($tipo == "tr"){

            $resultado = mysqli_query($conexion, "SELECT cedula, pin FROM transportista WHERE cedula = $CI");
                
            if($resultado){

                $filaAsociativa = mysqli_fetch_array($resultado);

                $ciBD = $filaAsociativa["cedula"];
                $pinBD = $filaAsociativa["pin"];

                if($PIN == $pinBD){

                    cerrarConexion($conexion);
                    header("Location: inicio.php?type=tr");
                    die();
                }
            }
        }
    }


?>