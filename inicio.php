
  <?php include('head.php');
        include('libreriaFunciones.php'); ?>

  <body class="">
    <div id="cont">

        

        <!-- HEADER -->
        <?php 
            if(!empty($_GET)) {

                $tipo = $_GET["type"];
                if($tipo != "vs"){
                    $ci = $_GET["ci"];
                    $nom = buscarNombre($ci, $tipo);
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
                        

                        <!-- acá va el contenido 
                        <table>
                            <tr>
                                <th>TÍTULO</th>
                                <th>TÍTULO</th>
                                <th>TÍTULO</th>
                                <th>TÍTULO</th>
                                <th>TÍTULO</th>
                                <th>TÍTULO</th>
                            </tr>

                            <tr>
                                <td>Descr.</td>
                                <td>Descr.</td>
                                <td>Descr.</td>
                                <td>Descr.</td>
                                <td>Descr.</td>
                                <td>Descr.</td>
                            </tr>
                        </table>-->

                        

                        <?php
                        include_once('libreriaFunciones.php');
                        //$tipo = $_GET["type"];

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
                                        echo "<th align=center>Perecedero</th></tr>";
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
                                        
                                        $fechaEstimada = $arrayPaquetesAsignados["0"]["fechaEstimada"];
                                        $estado = $arrayPaquetesAsignados["0"]["estado"];
                                        $fechaAsignacion = $arrayPaquetesAsignados["0"]["fechaAsignacion"];
                    

                                        echo "<tr><td align=center>" . $codigo;
                                        echo "<td align=center>" . $dirRemitente;
                                        echo "<td align=center>" . $dirEnvio;
                                        echo "<td align=center>" . $fragil;
                                        echo "<td align=center>" . $perecedero;
                                        echo "<td align=center>" . $fechaEstimada;
                                        echo "<td align=center>" . $estado;
                                        echo "<td align=center>" . $fechaAsignacion;
                                        echo "<td align=center> <a href='inicio.php?type=$tipo&ci=$ci&m=1&n=0'>Marcar como entregado</a></tr><br>";

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
                                        echo "<th align=center>Perecedero</th></tr>";
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
                                                echo "<th align=center>Estado</th>";

                                                $codigo = $arrayHistorial[0][0]["codigo"];
                                                $fechaEstimada = $arrayHistorial[0][0]["fechaEstimada"];
                                                $estado = $arrayHistorial[0][0]["estado"];

                                                echo "<tr><td align=center>" . $codigo;
                                                echo "<td align=center>" . $fechaEstimada;
                                                echo "<td align=center>" . $estado;

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
                                                    echo "<th align=center>Estado</th>";
                                                }


                                                for($i = 0; $i < $cant_filas2; $i++){
                                                    
                                                    $codigo = $arrayHistorial[1][$i]["codigo"];
                                                    $fechaEntrega = $arrayHistorial[1][$i]["fechaEntrega"];
                                                    $estado = $arrayHistorial[1][$i]["estado"];
                                                

                                                    echo "<tr><td align=center>" . $codigo;
                                                    echo "<td align=center>" . $fechaEntrega;
                                                    echo "<td align=center>" . $estado;

                                                }

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
