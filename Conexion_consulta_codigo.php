<?php

$conexion = mysqli_connect('127.0.0.1','root','','bdobligatorio');
	if(!$conexion){
		die (" error al conectar con base ");
            }

    $consultauno = "SELECT *FROM paquete where Codigo='$codigo'  and Estado='$estado'";
   
    $resultadouno = mysqli_query($conexion, $consultauno);
        if (!$resultadouno ){
       echo mysqli_error($conexion);
   
        }
      
       

?>