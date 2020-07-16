<?php 

if(!empty($_GET["m"])){

    $metodo = $_GET["m"];

    if($metodo == 1){

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

        $arrayPaquetesAsignados = paquetesAsignados($conexion, $ci);

        $cant_filas = count($arrayPaquetesAsignados);

        if($cant_filas > 0){

            echo "<table><tr>";
            echo "<tr><th align=center>Codigo</th>";
            echo "<th align=center>Dir. Remitente</th>";
            echo "<th align=center>Dir. Envio</th>";
            echo "<th align=center>Fragil</th>";
            echo "<th align=center>Perecedero</th>";
            echo "<th align=center>Fecha Estimada de Entrega</th>";
            echo "<th align=center>Estado</th>";
            echo "<th align=center>Fecha de Asignacion</th>";
            echo "<th align=center>Entregado</th></tr>";

            $codigo = $arrayPaquetesAsignados["0"]["codigo"];
            $dirRemitente = $arrayPaquetesAsignados["0"]["dirRemitente"];
            $dirEnvio = $arrayPaquetesAsignados["0"]["dirEnvio"];
            
            if($arrayPaquetesAsignados["0"]["fragil"])
                $fragil = "Si";
            else
                $fragil = "No";

            if($arrayPaquetesAsignados["0"]["perecedero"])
                $perecedero = "Si";
            else
                $perecedero = "No";

            $fechaArray = $arrayPaquetesAsignados["0"]["fechaEstimada"];
            $timestamp = strtotime($fechaArray);
            $fechaEstimada = date("d/m/Y", $timestamp);
            
            $estado = $arrayPaquetesAsignados["0"]["estado"];

            $fechaArray = $arrayPaquetesAsignados["0"]["fechaAsignacion"];
            $timestamp = strtotime($fechaArray);
            $fechaAsignacion = date("d/m/Y", $timestamp);

            echo "<tr><td align=center>" . $codigo . "</td>";
            echo "<td align=center>" . $dirRemitente . "</td>";
            echo "<td align=center>" . $dirEnvio . "</td>";
            echo "<td align=center>" . $fragil . "</td>";
            echo "<td align=center>" . $perecedero . "</td>";
            echo "<td align=center>" . $fechaEstimada . "</td>";
            echo "<td align=center>" . $estado . "</td>";
            echo "<td align=center>" . $fechaAsignacion . "</td>";
            echo "<td align=center width=200> <a href='inicio.php?m=1&n=0'>Marcar como entregado</a></td></tr><br>";
            echo "</table>";

            if(isset($_GET["n"])){

                $numPaquete = $_GET["n"];

                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                if($conexion == '1')
                    echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
                
                $codigoPaqueteEntrega = $arrayPaquetesAsignados["0"]["codigo"];

                entregarPaquete($conexion, $codigoPaqueteEntrega, $ci);

                if(array_key_exists("entregar", $_POST)){

                    if(!empty($_POST)) {
        
                    $fechaEntrega = $_POST["fechaEntrega"];

                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                    if($conexion == '1')
                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                    entregaPaqueteABD($conexion, $ci, $fechaEntrega, $codigoPaqueteEntrega);
                        
                    }
                }
            }
        }
    }else if($metodo == 5){

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
        
        $msjPaqueteNo = "";
        $arrayPaquetesNoAsignados = paquetesNoAsignados($conexion, $msjPaqueteNo);

        $cant_filas = count($arrayPaquetesNoAsignados);

        if($cant_filas > 0){
            
            echo "<table><tr>";
            echo "<tr><th align=center>Codigo</th>";
            echo "<th align=center>Dir. Remitente</th>";
            echo "<th align=center>Dir. Envio</th>";
            echo "<th align=center>Fragil</th>";
            echo "<th align=center>Perecedero</th>";
            echo "<th align=center>Asignarme</th></tr>";

            for($i = 0; $i < count($arrayPaquetesNoAsignados); $i++){
                
                $codigo = $arrayPaquetesNoAsignados[$i]["codigo"];
                $dirRemitente = $arrayPaquetesNoAsignados[$i]["dirRemitente"];
                $dirEnvio = $arrayPaquetesNoAsignados[$i]["dirEnvio"];
                
                if($arrayPaquetesNoAsignados[$i]["fragil"])
                    $fragil = "Si";
                else
                    $fragil = "No";

                if($arrayPaquetesNoAsignados[$i]["perecedero"])
                    $perecedero = "Si";
                else
                    $perecedero = "No";


                echo "<tr><td align=center>" . $codigo . "</td>";
                echo "<td align=center>" . $dirRemitente . "</td>";
                echo "<td align=center>" . $dirEnvio . "</td>";
                echo "<td align=center>" . $fragil . "</td>";
                echo "<td align=center>" . $perecedero . "</td>";
                echo "<td align=center> <a href='inicio.php?m=5&n=$i'>Asignar</a></td></tr>";

            }

            echo "</table>";

        } else {

            echo '<div class="msj alerta">'.$msjPaqueteNo.'</div>';
        }

        if(isset($_GET["n"])){

            $numPaquete = $_GET["n"];

            $conexion = crearConexion("localhost", "root", "", "obligatorio");
            if($conexion == '1')
                echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
            
            asignarPaquete($conexion, $ci);

            if(array_key_exists("asignar", $_POST)){

                if(!empty($_POST)) {
    
                $codigoPaqueteAsignacion = $arrayPaquetesNoAsignados[$numPaquete]["codigo"];
                $fechaEstimadaAsignacion = $_POST["fechaEstimada"];

                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                if($conexion == '1')
                    echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                asignacionDePaqueteABD($conexion, $ci, $codigoPaqueteAsignacion, $fechaEstimadaAsignacion);
                    
                }
            }
        }

    } else if($metodo == 4) {

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
        
        $arrayHistorial = historialPaquetes($conexion, $ci);

        if($arrayHistorial != null){

            if(isset($arrayHistorial[0])){
                $cant_filas1 = count($arrayHistorial[0]);

                if($cant_filas1 > 0){

                    echo "<table><tr>";
                    echo "<tr><th align=center>Codigo</th>";
                    echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                    echo "<th align=center>Estado</th></tr>";

                    $codigo = $arrayHistorial[0][0]["codigo"];

                    $fechaArray = $arrayHistorial[0][0]["fechaEstimada"];
                    $timestamp = strtotime($fechaArray);
                    $fechaEstimada = date("d/m/Y", $timestamp);

                    $estado = $arrayHistorial[0][0]["estado"];

                    echo "<tr><td align=center>" . $codigo . "</td>";
                    echo "<td align=center>" . $fechaEstimada . "</td>";
                    echo "<td align=center>" . $estado . "</td></tr>";

                    if(!isset($arrayHistorial[1]))
                        echo "</table>";
                
                }
            }

            if(isset($arrayHistorial[1])){
                $cant_filas2 = count($arrayHistorial[1]);

                if($cant_filas2 > 0){
                    
                    if(!isset($cant_filas1)){
                
                        echo "<table><tr>";
                        echo "<tr><th align=center>Codigo</th>";
                        echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                        echo "<th align=center>Estado</th></tr>";
                    }


                    for($i = 0; $i < $cant_filas2; $i++){
                        
                        $codigo = $arrayHistorial[1][$i]["codigo"];

                        $fechaArray = $arrayHistorial[1][$i]["fechaEntrega"];
                        $timestamp = strtotime($fechaArray);
                        $fechaEntrega = date("d/m/Y", $timestamp);

                        $estado = $arrayHistorial[1][$i]["estado"];
                    

                        echo "<tr><td align=center>" . $codigo . "</td>";
                        echo "<td align=center>" . $fechaEntrega . "</td>";
                        echo "<td align=center>" . $estado . "</td></tr>";

                    }

                    echo "</table>";

                }
            }
        } else 
            echo "<div class='msj alerta'>No tiene paquetes entregados o por entregar</div>";

    }
} 


?>