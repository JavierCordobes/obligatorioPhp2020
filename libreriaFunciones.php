<?php



    function conectarSQL($ip = "localhost", $user = "root", $pass = ""){

        return mysqli_connect($ip, $user, $pass);
    }

    function conectarBD($conexion, $bd){

        return mysqli_select_db($conexion, $bd);

    }
    
    function cerrarConexion($conexion){

        mysqli_close($conexion);
    }



    function ingreso($CI, $PIN, $conexion, $tipo){


        if($tipo == "en"){

            $resultado = mysqli_query($conexion, "SELECT cedula, pin FROM encargado WHERE cedula = $CI");
            
            if($resultado){

                $filaAsociativa = mysqli_fetch_array($resultado);
    
                $ciBD = $filaAsociativa["cedula"];
                $pinBD = $filaAsociativa["pin"];

                if($PIN == $pinBD){

                    cerrarConexion($conexion);
                    header("Location: inicio.php?type=en&ci=$ciBD&m=1");
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
                    header("Location: inicio.php?type=tr&ci=$ciBD&m=1");
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

    function buscarPaquete($codigo, $conexion) {

        $consulta = mysqli_query($conexion, "SELECT estado, fechaEstimada, fechaEntrega FROM paquete WHERE codigo = '$codigo'");

        if($consulta){

            $filaAsociativa = mysqli_fetch_array($consulta);

            //Mira que el estado del paquete no este vacio, si esta se informa que no se encontro
            if(empty($filaAsociativa["estado"])){
                
                echo "No se encontro el paquete";
            //Buscamos la fecha estimada, si esta entonces mandamos la fecha estimada del paquete
            } else if (!empty($filaAsociativa["fechaEstimada"])){
                

                $resu = array (
                    "estado" => $filaAsociativa["estado"],
                    "fechaPaquete" => $filaAsociativa["fechaEstimada"],
                );
                return $resu;
            //Buscamos la fecha de entrega, si esta entonces mandamos la fecha estimada del paquete
            } else if(!empty($filaAsociativa["fechaEntrega"])){
            
                $resu = array (
                    "estado" => $filaAsociativa["estado"],
                    "fechaPaquete" => $filaAsociativa["fechaEntrega"],
                );
                return $resu;
            //Si no estan ninguna de las fechas entonces el paquete no esta asignado y solo le mandamos el estado
            } else {

                $resu = array (
                    "estado" => $filaAsociativa["estado"],
                );
                return $resu;
            }

            
        } else {

            echo "Ocurrio un error en la consulta.";
        }
         

    }

    function paquetesNoAsignados($conexion) {

        $consulta = mysqli_query($conexion, "SELECT codigo, dirRemitente, dirEnvio, fragil, perecedero FROM paquete WHERE estado = 'No asignado'");

        if($consulta){
        
            $cant_filas = mysqli_num_rows($consulta);

            if($cant_filas == 0)
                echo "No hay paquetes sin asignar";
            else{

                $array = array();

                for($i = 0; $i < $cant_filas; $i++){

                    $filaAsociativa = mysqli_fetch_array($consulta);

                    $codigo = $filaAsociativa["codigo"];
                    $dirRemitente = $filaAsociativa["dirRemitente"];
                    $dirEnvio = $filaAsociativa["dirEnvio"];
                    
                    if($filaAsociativa["fragil"] == 1)
                        $fragil = true;
                    else
                        $fragil = false;

                    if($filaAsociativa["perecedero"] == 1)
                        $perecedero = true;
                    else
                        $perecedero = false;

                    $array[$i]["codigo"] = $codigo;
                    $array[$i]["dirRemitente"] = $dirRemitente;
                    $array[$i]["dirEnvio"] = $dirEnvio;
                    $array[$i]["fragil"] = $fragil;
                    $array[$i]["perecedero"] = $perecedero;
    
                }

                return $array;

            }
    
        } else {

            echo "Error en la consulta de paquetes";
        }


    }

    function asignarPaquete($conexion, $ciTransportista){

        $consulta = mysqli_query($conexion, "SELECT codigo, fechaAsignacion, ciTransportista FROM paquete WHERE estado = 'Asignado'");

        if($consulta){

            $cant_filas = mysqli_num_rows($consulta);

            if($cant_filas > 0){

                for($i = 0; $i < $cant_filas; $i++){
                    $filaAsociativa = mysqli_fetch_array($consulta);

                    $ciAsignada = $filaAsociativa["ciTransportista"];

                    if($ciAsignada == $ciTransportista){
                        
                        $codigo = $filaAsociativa["codigo"];
                        $fechaBD = $filaAsociativa["fechaAsignacion"];
                        $timestamp = strtotime($fechaBD);
                        $fechaAsignacion = date("d/m/Y", $timestamp);

                        echo "<br> Ya tiene un paquete asignado, el codigo del paquete es: $codigo, y le fue asignado el dia: $fechaAsignacion.";

                    } else {

                        echo "<br> <form name=asignar method=POST action=''>";
                        echo "Ingrese una fecha estimada de entrega para el paquete: ";
                        echo "<input type=date name=fechaEstimada required>";
                        echo "<input type=submit name=asignar id=asignar value=ASIGNAR>";

                        echo "</form>";
                    }

                }
            } else {

                echo "<br> <form name=asignar method=POST action=''>";
                echo "Ingrese una fecha estimada de entrega para el paquete: ";
                echo "<input type=date name=fechaEstimada required>";
                echo "<input type=submit name=asignar id=asignar value=ASIGNAR>";

                echo "</form>";
            }

        } else {

            echo "<br> Error en la consulta de paquetes";
        }

    }
        
    function asignacionDePaqueteABD($conexion, $ciTransportista, $codigoPaquete, $fechaEstimada){

        $fechaAsignado = date('Y-m-d');

        $consulta = mysqli_query($conexion, "UPDATE paquete SET fechaEstimada = '$fechaEstimada', estado = 'Asignado', fechaAsignacion = '$fechaAsignado', ciTransportista = '$ciTransportista' WHERE codigo = '$codigoPaquete'");

        if($consulta){

            echo "<meta http-equiv='refresh' content='0.3;url=inicio.php?type=tr&ci=$ciTransportista&m=1'>";
            die();
        } else {
            echo "Ocurrio un error en la consulta";
        }
    }

    //Muestra la informacion de los paquetes, se usa para trnasportista y encargado
    function paquetesAsignados($conexion, $ciTransportista = 0){

        if($ciTransportista == 0){
            
            $query = "SELECT codigo, dirRemitente, dirEnvio, fragil, perecedero, fechaEstimada, estado, fechaAsignacion, ciTransportista FROM paquete WHERE estado = 'Asignado'";
        } else {

            $query = "SELECT codigo, dirRemitente, dirEnvio, fragil, perecedero, fechaEstimada, estado, fechaAsignacion FROM paquete WHERE estado = 'Asignado' AND ciTransportista = '$ciTransportista'";
        }

        $consulta = mysqli_query($conexion, $query);

        if($consulta){
        
            $cant_filas = mysqli_num_rows($consulta);

            if($cant_filas == 0){

                if($ciTransportista == 0){

                    echo "No tiene paquetes asignados";
                }else{

                    echo "No hay paquetes asignados";
                }
            } else {

                    $array = array();

                    for($i = 0; $i < $cant_filas; $i++){

                        $filaAsociativa = mysqli_fetch_array($consulta);

                        $codigo = $filaAsociativa["codigo"];
                        $dirRemitente = $filaAsociativa["dirRemitente"];
                        $dirEnvio = $filaAsociativa["dirEnvio"];
                        
                        if($filaAsociativa["fragil"] == 1)
                            $fragil = true;
                        else
                            $fragil = false;

                        if($filaAsociativa["perecedero"] == 1)
                            $perecedero = true;
                        else
                            $perecedero = false;

                        $fechaEstimada = $filaAsociativa["fechaEstimada"];
                        $estado = $filaAsociativa["estado"];
                        $fechaAsignacion = $filaAsociativa["fechaAsignacion"];

                        $array[$i]["codigo"] = $codigo;
                        $array[$i]["dirRemitente"] = $dirRemitente;
                        $array[$i]["dirEnvio"] = $dirEnvio;
                        $array[$i]["fragil"] = $fragil;
                        $array[$i]["perecedero"] = $perecedero;
                        $array[$i]["fechaEstimada"] = $fechaEstimada;
                        $array[$i]["estado"] = $estado;
                        $array[$i]["fechaAsignacion"] = $fechaAsignacion;


                        if($ciTransportista == 0){

                            $ciTr = $filaAsociativa["ciTransportista"];
                            $consultaTr = mysqli_query($conexion, "SELECT nombres, apellidos FROM transportista WHERE cedula = $ciTr");

                            if($consultaTr){

                                $filaAsociativaTr = mysqli_fetch_array($consultaTr);
                                $nombre = $filaAsociativaTr["nombres"];
                                $apellido = $filaAsociativaTr["apellidos"];

                                $nombreCompleto = $nombre . $apellido;

                                $array[$i]["ciTransportista"] = $ciTr;
                                $array[$i]["nombreCompleto"] = $nombreCompleto;

                            }

                        }
                    }
                    return $array;
                }
        } else {

            echo "Error en la consulta de paquetes";
        }


    }

    function entregarPaquete($conexion, $codigoPaquete, $ciTransportista){

        $consulta = mysqli_query($conexion, "SELECT ciTransportista FROM paquete WHERE codigo = '$codigoPaquete'");

        if($consulta){

            $filaAsociativa = mysqli_fetch_array($consulta);
            $ciBD = $filaAsociativa["ciTransportista"];

            if($ciTransportista == $ciBD){

                echo "<br> <form name=entregar method=POST action=''>";
                echo "Ingrese la fecha de entrega del paquete: ";
                echo "<input type=date name=fechaEntrega required>";
                echo "<input type=submit name=entregar id=entregar value=ENTREGAR>";

                echo "</form>";

            } else {
                echo "El transportista no coincide con el asignado.";
            }

        } else 
            echo "Ocurrio un error en la consulta";

    }

    function entregaPaqueteABD($conexion, $ciTransportista, $fechaEntrega, $codigoPaquete){

        $consulta = mysqli_query($conexion, "UPDATE paquete SET fechaEntrega = '$fechaEntrega', estado = 'Entregado' WHERE codigo = '$codigoPaquete'");

        if(!$consulta){

            echo "Ocurrio un error en la consulta";
        } else {

            echo "<meta http-equiv='refresh' content='0.3;url=inicio.php?type=tr&ci=$ciTransportista&m=1'>";
            die();
        }
    }

    function historialPaquetes($conexion, $ciTransportista = 0){

        $resu = array();
        //Primero busco los paquetes asignados
        if($ciTransportista == 0)      
            $consulta1 = mysqli_query($conexion, "SELECT codigo, fechaEstimada, estado, ciTransportista FROM paquete WHERE estado = 'Asignado'");
        else 
            $consulta1 = mysqli_query($conexion, "SELECT codigo, fechaEstimada, estado FROM paquete WHERE estado = 'Asignado' AND ciTransportista = '$ciTransportista'");

        if($consulta1){
        
            $cant_filas = mysqli_num_rows($consulta1);

            if($cant_filas > 0){

                $array1 = array();

                for($i = 0; $i < $cant_filas; $i++){

                    $filaAsociativa = mysqli_fetch_array($consulta1);

                    $codigo = $filaAsociativa["codigo"];
                    $fechaEstimada = $filaAsociativa["fechaEstimada"];
                    $estado = $filaAsociativa["estado"];
                    if($ciTransportista == 0){
                        $ciTransportista = $filaAsociativa["ciTransportista"];
                        $array1[$i]["ciTransportista"] = $ciTransportista;
                    }


                    $array1[$i]["codigo"] = $codigo;
                    $array1[$i]["fechaEstimada"] = $fechaEstimada;
                    $array1[$i]["estado"] = $estado;

    
                }

                $resu[0] = $array1;

            }
    
        } else {

            echo "Error en la consulta de paquetes";
        }

        //Despues hago lo mismo pero con los paquetes asignados previamente al Transportista y el resto para el Encargado
        if($ciTransportista == 0)      
            $consulta2 = mysqli_query($conexion, "SELECT codigo, fechaEntrega, estado, ciTransportista FROM paquete");
        else 
            $consulta2 = mysqli_query($conexion, "SELECT codigo, fechaEntrega, estado FROM paquete WHERE estado = 'Entregado' AND ciTransportista = '$ciTransportista'");

        if($consulta2){
        
            $cant_filas = mysqli_num_rows($consulta2);

            if($cant_filas > 0){

                $array2 = array();

                for($i = 0; $i < $cant_filas; $i++){

                    $filaAsociativa = mysqli_fetch_array($consulta2);

                    $codigo = $filaAsociativa["codigo"];
                    $estado = $filaAsociativa["estado"];
                    
                    $array2[$i]["codigo"] = $codigo;
                    $array2[$i]["estado"] = $estado;

                    if($ciTransportista == 0){

                        $ciTransportista = $filaAsociativa["ciTransportista"];
                        $array2[$i]["ciTransportista"] = $ciTransportista;

                        //Guardo la fecha de entrega solamente si la tiene, para evitar errores con los paquetes no asignados, luego hago lo mismo en el inicio para filtrar en el historial de encargado
                        if(!empty($filaAsociativa["fechaEntrega"])){
                            
                            $fechaEntrega = $filaAsociativa["fechaEntrega"];
                            $array2[$i]["fechaEntrega"] = $fechaEntrega;
                        }
                    } else {

                        $fechaEntrega = $filaAsociativa["fechaEntrega"];
                        $array2[$i]["fechaEntrega"] = $fechaEntrega;
                    }
    
                }

                $resu[1] = $array2;

            }
    
        } else {

            echo "Error en la consulta de paquetes";
        }

        return $resu;

    }

    
?>