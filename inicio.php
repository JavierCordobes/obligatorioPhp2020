
  <?php include('head.php');
        include('libreriaFunciones.php'); 
        session_start()?>

  <body class="">
    <div id="cont">

        

        <!-- HEADER -->
        <?php 



        if(!empty($_GET["m"])){

            $metodo = $_GET["m"];

            if($metodo == 10){
                cerrarSesion();
            }

        } 

        if(!empty($_SESSION)) {

            $tipo = $_SESSION["tipo"];
            if($tipo != "vs"){
                $ci = $_SESSION["cedula"];
                $nom = $_SESSION["nombre"];
            } else {
                $nom = "Visitante";
            }
            include("header.php");
        }
        
            
        ?>


        

        <!-- MAIN -->
        <main id="main" role="main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
 
                        <?php
                        include_once('libreriaFunciones.php');

                        if($tipo == "vs"){

                            echo "<form method=POST name=estadoPaquete>";

                            echo "<input name=codigo type=text placeholder=Codigo>";

                            echo "<input type=submit name=buscarPaquete id=buscarPaquete value=buscarPaquete>";

                            echo "</form>";

                            if(array_key_exists("buscarPaquete", $_POST)){

                                if(empty($_POST)) {
            
                                    echo "No se pudo enviar o no se encontro el paquete";

                                } else {

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");

                                    $codigoBusqueda = $_POST["codigo"];
                    
                                    $arrayPaquete = buscarPaquete($codigoBusqueda, $conexion);

                                    cerrarConexion($conexion);

                                    if(!empty($arrayPaquete)){

                                        $estadoPaquete = $arrayPaquete["estado"];

                                        echo "Estado del paquete: $estadoPaquete. ";

                                        if(!empty($arrayPaquete["fechaPaquete"])){

                                            $fechaArray = $arrayPaquete["fechaPaquete"];
                                            $timestamp = strtotime($fechaArray);
                                            $fechaPaquete = date("d/m/Y", $timestamp);

                                            if($estadoPaquete == "Asignado")
                                                echo "Fecha estimada de entrega: $fechaPaquete";
                                            else
                                                echo "Fecha de entrega: $fechaPaquete";
                                        }
                                    }
                                }
                            }

                        } else if ($tipo == "tr"){

                            if(!empty($_GET["m"])){

                                $metodo = $_GET["m"];

                                if($metodo == 1){

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");

                                    $arrayPaquetesAsignados = paquetesAsignados($conexion, $ci);

                                    cerrarConexion($conexion);

                                    $cant_filas = count($arrayPaquetesAsignados);

                                    if($cant_filas > 0){

                                        echo "<table border=1><tr>";
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

                                        echo "<tr><td align=center>" . $codigo;
                                        echo "<td align=center>" . $dirRemitente;
                                        echo "<td align=center>" . $dirEnvio;
                                        echo "<td align=center>" . $fragil;
                                        echo "<td align=center>" . $perecedero;
                                        echo "<td align=center>" . $fechaEstimada;
                                        echo "<td align=center>" . $estado;
                                        echo "<td align=center>" . $fechaAsignacion;
                                        echo "<td align=center> <a href='inicio.php?type=$tipo&ci=$ci&m=1&n=0'>Marcar como entregado</a></td></tr><br>";
                                        echo "</table>";

                                        if(isset($_GET["n"])){

                                            $numPaquete = $_GET["n"];

                                            $conexion = conectarSQL();
                                            if(!$conexion)
                                                die("Error en la conexion al servidor");
                                    
                                            $conexionBD = conectarBD($conexion, "Obligatorio");
                                            if(!$conexionBD)
                                                die("Error en la conexion a la base de datos");
                                            
                                            $codigoPaqueteEntrega = $arrayPaquetesAsignados["0"]["codigo"];

                                            entregarPaquete($conexion, $codigoPaqueteEntrega, $ci);
    
                                            cerrarConexion($conexion);

                                            if(array_key_exists("entregar", $_POST)){

                                                if(!empty($_POST)) {
                                    
                                                $fechaEntrega = $_POST["fechaEntrega"];

                                                $conexion = conectarSQL();
                                                if(!$conexion)
                                                    die("Error en la conexion al servidor");
                                        
                                                $conexionBD = conectarBD($conexion, "Obligatorio");
                                                if(!$conexionBD)
                                                    die("Error en la conexion a la base de datos"); 

                                                entregaPaqueteABD($conexion, $ci, $fechaEntrega, $codigoPaqueteEntrega);
                                                
                                                cerrarConexion($conexion);

                                                    
                                                }
                                            }
                                        }
                                    }
                                }else if($metodo == 5){

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");
                                    
                                    $arrayPaquetesNoAsignados = paquetesNoAsignados($conexion);

                                    cerrarConexion($conexion);

                                    $cant_filas = count($arrayPaquetesNoAsignados);

                                    if($cant_filas > 0){
                                        
                                        echo "<table border=1><tr>";
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
                            

                                            echo "<tr><td align=center>" . $codigo;
                                            echo "<td align=center>" . $dirRemitente;
                                            echo "<td align=center>" . $dirEnvio;
                                            echo "<td align=center>" . $fragil;
                                            echo "<td align=center>" . $perecedero;
                                            echo "<td align=center> <a href='inicio.php?type=$tipo&ci=$ci&m=5&n=$i'>Asignar</a></tr>";

                                        }

                                        echo "</table>";

                                    }

                                    if(isset($_GET["n"])){

                                        $numPaquete = $_GET["n"];

                                        $conexion = conectarSQL();
                                        if(!$conexion)
                                            die("Error en la conexion al servidor");
                                
                                        $conexionBD = conectarBD($conexion, "Obligatorio");
                                        if(!$conexionBD)
                                            die("Error en la conexion a la base de datos");
                                        
                                        asignarPaquete($conexion, $ci);

                                        cerrarConexion($conexion);

                                        if(array_key_exists("asignar", $_POST)){

                                            if(!empty($_POST)) {
                                
                                            $codigoPaqueteAsignacion = $arrayPaquetesNoAsignados[$numPaquete]["codigo"];
                                            $fechaEstimadaAsignacion = $_POST["fechaEstimada"];

                                            $conexion = conectarSQL();
                                            if(!$conexion)
                                                die("Error en la conexion al servidor");
                                    
                                            $conexionBD = conectarBD($conexion, "Obligatorio");
                                            if(!$conexionBD)
                                                die("Error en la conexion a la base de datos"); 

                                            asignacionDePaqueteABD($conexion, $ci, $codigoPaqueteAsignacion, $fechaEstimadaAsignacion);

                                            cerrarConexion($conexion);

                                                
                                            }
                                        }
                                    }

                                } else if($metodo == 4) {

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");
                                    
                                    $arrayHistorial = historialPaquetes($conexion, $ci);

                                    cerrarConexion($conexion);

                                    if($arrayHistorial != null){

                                        if(isset($arrayHistorial[0])){
                                            $cant_filas1 = count($arrayHistorial[0]);

                                            if($cant_filas1 > 0){

                                                echo "<table border=1><tr>";
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
                                            
                                                    echo "<table border=1><tr>";
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
                                        echo "No tiene paquetes entregados o por entregar";

                                }
                            } 
                        } else if ($tipo == "en"){

                            if(!empty($_GET["m"])){

                                $metodo = $_GET["m"];

                                if($metodo == 1){

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");

                                    $arrayPaquetesAsignados = paquetesAsignados($conexion);

                                    cerrarConexion($conexion);

                                    $cant_filas = count($arrayPaquetesAsignados);

                                    if($cant_filas > 0){

                                        echo "<table border=1><tr>";
                                        echo "<tr><th align=center>Codigo</th>";
                                        echo "<th align=center>Dir. Remitente</th>";
                                        echo "<th align=center>Dir. Envio</th>";
                                        echo "<th align=center>Fragil</th>";
                                        echo "<th align=center>Perecedero</th>";
                                        echo "<th align=center>Fecha Estimada de Entrega</th>";
                                        echo "<th align=center>Estado</th>";
                                        echo "<th align=center>Cedula del Transportista</th>";
                                        echo "<th align=center>Nombre completo</th>";
                                        echo "<th align=center>Fecha de Asignacion</th></tr>";

                                        for($i = 0; $i < $cant_filas; $i++){

                                            $codigo = $arrayPaquetesAsignados[$i]["codigo"];
                                            $dirRemitente = $arrayPaquetesAsignados[$i]["dirRemitente"];
                                            $dirEnvio = $arrayPaquetesAsignados[$i]["dirEnvio"];
                                            
                                            if($arrayPaquetesAsignados[$i]["fragil"])
                                                $fragil = "Si";
                                            else
                                                $fragil = "No";

                                            if($arrayPaquetesAsignados[$i]["perecedero"])
                                                $perecedero = "Si";
                                            else
                                                $perecedero = "No";
                                            
                                            $fechaArray = $arrayPaquetesAsignados[$i]["fechaEstimada"];
                                            $timestamp = strtotime($fechaArray);
                                            $fechaEstimada = date("d/m/Y", $timestamp);

                                            $estado = $arrayPaquetesAsignados[$i]["estado"];

                                            $ciTransportista = $arrayPaquetesAsignados[$i]["ciTransportista"];
                                            $nombreCompleto = $arrayPaquetesAsignados[$i]["nombreCompleto"];

                                            $fechaArray = $arrayPaquetesAsignados[$i]["fechaAsignacion"];
                                            $timestamp = strtotime($fechaArray);
                                            $fechaAsignacion = date("d/m/Y", $timestamp);                        

                                            echo "<tr><td align=center>" . $codigo . "</td>";
                                            echo "<td align=center>" . $dirRemitente . "</td>";
                                            echo "<td align=center>" . $dirEnvio . "</td>";
                                            echo "<td align=center>" . $fragil . "</td>";
                                            echo "<td align=center>" . $perecedero . "</td>";
                                            echo "<td align=center>" . $fechaEstimada . "</td>";
                                            echo "<td align=center>" . $estado . "</td>";
                                            echo "<td align=center>" . $ciTransportista . "</td>";
                                            echo "<td align=center>" . $nombreCompleto . "</td>";
                                            echo "<td align=center>" . $fechaAsignacion . "</td></tr><br>";
                                            echo "</table>";
                                        }
                                    }
                                } else if($metodo == 4) {

                                    $conexion = conectarSQL();
                                    if(!$conexion)
                                        die("Error en la conexion al servidor");
                            
                                    $conexionBD = conectarBD($conexion, "Obligatorio");
                                    if(!$conexionBD)
                                        die("Error en la conexion a la base de datos");
                                    
                                    $arrayHistorial = historialPaquetes($conexion);
    
                                    cerrarConexion($conexion);
    
                                    if($arrayHistorial != null){
    
                                        if(isset($arrayHistorial[0])){
                                            $cant_filas0 = count($arrayHistorial[0]);
    
                                            if($cant_filas0 > 0){
    
                                                echo "<table border=1><tr>";
                                                echo "<tr><th align=center>Codigo</th>";
                                                echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                                                echo "<th align=center>Estado</th>";
                                                echo "<th align=center>Cedula del Transportista</th>";
                                                echo "<th align=center>Nombre completo</th></tr>";



                                                for($i = 0; $i < $cant_filas0; $i++){
    
                                                    $codigo = $arrayHistorial[0][$i]["codigo"];
                        
                                                    $fechaArray = $arrayHistorial[0][$i]["fechaEstimada"];
                                                    $timestamp = strtotime($fechaArray);
                                                    $fechaEstimada = date("d/m/Y", $timestamp);

                                                    $estado = $arrayHistorial[0][$i]["estado"];
                                                    $ciTransportista = $arrayHistorial[0][$i]["ciTransportista"];
                                                    $nombreCompleto = $arrayHistorial[0][$i]["nombreCompleto"];

        
                                                    echo "<tr><td align=center>" . $codigo . "</td>";
                                                    echo "<td align=center>" . $fechaEstimada . "</td>";
                                                    echo "<td align=center>" . $estado . "</td>";
                                                    echo "<td align=center>" . $ciTransportista . "</td>";
                                                    echo "<td align=center>" . $nombreCompleto . "</td></tr>";
        
                                                }

                                                if(!isset($arrayHistorial[1]) && !isset($arrayHistorial[2]))
                                                        echo "</table>";
                                            }
                                        }

                                        //Agregamos el $arrayHistorial[2] aca porque es donde estan los paquetes sin asignar, para mostrarlos con mejor orden
                                        if(isset($arrayHistorial[2])){
                                            $cant_filas2 = count($arrayHistorial[2]);
    
                                            if($cant_filas2 > 0){

                                                if(!isset($cant_filas0)){
                                            
                                                    echo "<table border=1><tr>";
                                                    echo "<tr><th align=center>Codigo</th>";
                                                    echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                                                    echo "<th align=center>Estado</th>";
                                                    echo "<th align=center>Cedula del Transportista</th>";
                                                    echo "<th align=center>Nombre completo</th></tr>";
                                                
                                                }


                                                for($i = 0; $i < $cant_filas2; $i++){
    
                                                    $codigo = $arrayHistorial[2][$i]["codigo"];
                                                    $fechaEstimada = "Paquete aun no asignado.";
                                                    $estado = $arrayHistorial[2][$i]["estado"];
                                                    $ciTransportista = "Paquete aun no asignado.";
                                                    $nombreCompleto = "Paquete aun no asignado.";


        
                                                    echo "<tr><td align=center>" . $codigo . "</td>";
                                                    echo "<td align=center>" . $fechaEstimada . "</td>";
                                                    echo "<td align=center>" . $estado . "</td>";
                                                    echo "<td align=center>" . $ciTransportista . "</td>";
                                                    echo "<td align=center>" . $nombreCompleto . "</td></tr>";
        
                                                }

                                                if(!isset($arrayHistorial[1]))
                                                        echo "</table>";
                                            }
                                        }
    
                                        if(isset($arrayHistorial[1])){
                                            $cant_filas1 = count($arrayHistorial[1]);
    
                                            if($cant_filas1 > 0){
                                                
                                                if(!isset($cant_filas0) && !isset($cant_filas2)){
                                            
                                                    echo "<table border=1><tr>";
                                                    echo "<tr><th align=center>Codigo</th>";
                                                    echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                                                    echo "<th align=center>Estado</th>";
                                                    echo "<th align=center>Cedula del Transportista</th>";
                                                    echo "<th align=center>Nombre completo</th></tr>";
                                                
                                                }
    
    
                                                for($i = 0; $i < $cant_filas1; $i++){
                                                    
                                                    $codigo = $arrayHistorial[1][$i]["codigo"];

                                                    $fechaArray = $arrayHistorial[1][$i]["fechaEntrega"];
                                                    $timestamp = strtotime($fechaArray);
                                                    $fechaEntrega = date("d/m/Y", $timestamp);

                                                    $estado = $arrayHistorial[1][$i]["estado"];
                                                    $ciTransportista = $arrayHistorial[1][$i]["ciTransportista"];
                                                    $nombreCompleto = $arrayHistorial[1][$i]["nombreCompleto"];
                                                
    
                                                    echo "<tr><td align=center>" . $codigo . "</td>";
                                                    echo "<td align=center>" . $fechaEntrega . "</td>";
                                                    echo "<td align=center>" . $estado . "</td>";
                                                    echo "<td align=center>" . $ciTransportista . "</td>";
                                                    echo "<td align=center>" . $nombreCompleto . "</td></tr>";
    
                                                }
    
                                                if(!isset($arrayHistorial[1]) && !isset($arrayHistorial[2]))
                                                    echo "</table>";    
                                            }
                                        }
                                    } else 
                                        echo "No tiene paquetes entregados o por entregar";
                                } 
                            }   
                        }
                        ?>

                    </div>
                </div>
            </div>
            
            
        </main>



        <!-- FOOTER -->
        <?php include('footer.php') ?>



    </div>
  </body>
</html>
