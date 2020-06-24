<?php


    class conexionSQL {

        conectarSQL($ip = "localhost", $user = "root", $pass = ""){

            return mysqli_connect($ip, $user, $pass);
        }

        conectarBD($conexionSQL, $bd){

            return mysqli_select_db($conexion, $bd);

        }
        
        cerrarConexion($conexion){

            mysqli_close($conexion);
        }
    }

    


?>