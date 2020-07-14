
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
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
 
                        <?php
                        include_once('libreriaFunciones.php');

                        if($tipo == "vs"){

                            echo '
                            <form method=POST name="estadoPaquete">
                                <input name="codigo" type="text" placeholder="Codigo" required>
                                <input type="submit" name="buscarPaquete" id="buscarPaquete" value="Buscar Paquete">
                            </form>';

                            if(array_key_exists("buscarPaquete", $_POST)){

                                if(empty($_POST)) {
            
                                    echo '<div class="msj error">No se pudo enviar o no se encontro el paquete</div>';

                                } else {

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1'){
                                        echo '<div class="msj error">Hubo un error al conectarnos a la base de datos</div>';
                                    } else {
                                        
                                        $codigoBusqueda = $_POST["codigo"];
                    
                                        $msjPaquete = '';
                                        $arrayPaquete = buscarPaquete($codigoBusqueda, $conexion, $msjPaquete);
    
                                        if(!empty($arrayPaquete)){
    
                                            $estadoPaquete = $arrayPaquete["estado"];
    
                                            echo "Estado del paquete: $estadoPaquete. <br>";
    
                                            if(!empty($arrayPaquete["fechaPaquete"])){
    
                                                $fechaArray = $arrayPaquete["fechaPaquete"];
                                                $timestamp = strtotime($fechaArray);
                                                $fechaPaquete = date("d/m/Y", $timestamp);
    
                                                if($estadoPaquete == "Asignado")
                                                    echo "Fecha estimada de entrega: $fechaPaquete";
                                                else
                                                    echo "Fecha de entrega: $fechaPaquete";
                                            }
                                        } else 
                                            echo '<div class="msj error">'.$msjPaquete.'</div>';
                                    }    
                                }
                            }
                        } else if ($tipo == "tr"){

                            if(!empty($_GET["m"])){

                                $metodo = $_GET["m"];

                                if($metodo == 1){

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";

                                    $arrayPaquetesAsignados = paquetesAsignados($conexion, $ci);

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

                                        echo "<tr><td align=center>" . $codigo . "</td>";
                                        echo "<td align=center>" . $dirRemitente . "</td>";
                                        echo "<td align=center>" . $dirEnvio . "</td>";
                                        echo "<td align=center>" . $fragil . "</td>";
                                        echo "<td align=center>" . $perecedero . "</td>";
                                        echo "<td align=center>" . $fechaEstimada . "</td>";
                                        echo "<td align=center>" . $estado . "</td>";
                                        echo "<td align=center>" . $fechaAsignacion . "</td>";
                                        echo "<td align=center> <a href='inicio.php?m=1&n=0'>Marcar como entregado</a></td></tr><br>";
                                        echo "</table>";

                                        if(isset($_GET["n"])){

                                            $numPaquete = $_GET["n"];

                                            $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                            if($conexion == '1')
                                                echo "Hubo un error al conectarnos a la base de datos";
                                            
                                            $codigoPaqueteEntrega = $arrayPaquetesAsignados["0"]["codigo"];

                                            entregarPaquete($conexion, $codigoPaqueteEntrega, $ci);

                                            if(array_key_exists("entregar", $_POST)){

                                                if(!empty($_POST)) {
                                    
                                                $fechaEntrega = $_POST["fechaEntrega"];

                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                if($conexion == '1')
                                                    echo "Hubo un error al conectarnos a la base de datos";

                                                entregaPaqueteABD($conexion, $ci, $fechaEntrega, $codigoPaqueteEntrega);
                                                    
                                                }
                                            }
                                        }
                                    }
                                }else if($metodo == 5){

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";
                                    
                                    $msjPaqueteNo = "";
                                    $arrayPaquetesNoAsignados = paquetesNoAsignados($conexion, $msjPaqueteNo);

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
                            

                                            echo "<tr><td align=center>" . $codigo . "</td>";
                                            echo "<td align=center>" . $dirRemitente . "</td>";
                                            echo "<td align=center>" . $dirEnvio . "</td>";
                                            echo "<td align=center>" . $fragil . "</td>";
                                            echo "<td align=center>" . $perecedero . "</td>";
                                            echo "<td align=center> <a href='inicio.php?m=5&n=$i'>Asignar</a></td></tr>";

                                        }

                                        echo "</table>";

                                    } else {

                                        echo '<div class="msj error">'.$msjPaqueteNo.'</div>';
                                    }

                                    if(isset($_GET["n"])){

                                        $numPaquete = $_GET["n"];

                                        $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                        if($conexion == '1')
                                            echo "Hubo un error al conectarnos a la base de datos";
                                        
                                        asignarPaquete($conexion, $ci);

                                        if(array_key_exists("asignar", $_POST)){

                                            if(!empty($_POST)) {
                                
                                            $codigoPaqueteAsignacion = $arrayPaquetesNoAsignados[$numPaquete]["codigo"];
                                            $fechaEstimadaAsignacion = $_POST["fechaEstimada"];

                                            $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                            if($conexion == '1')
                                                echo "Hubo un error al conectarnos a la base de datos";

                                            asignacionDePaqueteABD($conexion, $ci, $codigoPaqueteAsignacion, $fechaEstimadaAsignacion);
                                                
                                            }
                                        }
                                    }

                                } else if($metodo == 4) {

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";
                                    
                                    $arrayHistorial = historialPaquetes($conexion, $ci);

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

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";

                                    $arrayPaquetesAsignados = paquetesAsignados($conexion);

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
                                } else if ($metodo == 2){

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";
                                    
                                    $arrayLista = listaPaquetes($conexion);
    

                                    echo "<a href='inicio.php?m=2&a=1'>Agregar un paquete</a><br>";

                                    if($arrayLista != null){

                                        $cant_filas = count($arrayLista);
    
                                        if($cant_filas > 0){

                                            echo "<table border=1><tr>";
                                            echo "<tr><th align=center>Codigo</th>";
                                            echo "<th align=center>Dir. Remitente</th>";
                                            echo "<th align=center>Dir. Envio</th>";
                                            echo "<th align=center>Fragil</th>";
                                            echo "<th align=center>Perecedero</th>";
                                            echo "<th align=center>Estado</th>";
                                            echo "<th align=center>Fecha de entrega / Fecha estimada de entrega</th>";
                                            echo "<th align=center>Cedula del Transportista</th>";
                                            echo "<th align=center>Fecha de asignacion</th>";
                                            echo "<th align=center>Modificar</th>";
                                            echo "<th align=center>Eliminar</th></tr>";



                                            for($i = 0; $i < $cant_filas; $i++){

                                                $codigo = $arrayLista[$i]["codigo"];
                                                $dirRemitente = $arrayLista[$i]["dirRemitente"];
                                                $dirEnvio = $arrayLista[$i]["dirEnvio"];
                                                $estado = $arrayLista[$i]["estado"];

                                                if($estado != 'No asignado'){

                                                    $fechaAsignacionArray = $arrayLista[$i]["fechaAsignacion"];
                                                    $timestamp = strtotime($fechaAsignacionArray);
                                                    $fechaAsignacion = date("d/m/Y", $timestamp);

                                                    $ciTransportista = $arrayLista[$i]["ciTransportista"];
                            
                                                    if($estado == 'Asignado'){
                            
                                                        $fechaEstimada = $arrayLista[$i]["fechaEstimada"];                                                                
                                                        $timestamp = strtotime($fechaEstimada);
                                                        $fechaPaquete = date("d/m/Y", $timestamp);

                                                    } else {
                            
                                                        $fechaEntrega = $arrayLista[$i]["fechaEntrega"];
                                                        $timestamp = strtotime($fechaEntrega);
                                                        $fechaPaquete = date("d/m/Y", $timestamp);
                                                    }
                                                } else {

                                                    $fechaAsignacion = "Paquete aun no asignado.";
                                                    $ciTransportista = "Paquete aun no asignado.";
                                                    $fechaPaquete = "Paquete aun no asignado.";
                                                }

                                                
                                                $fragilArray = $arrayLista[$i]["fragil"];
                                                if($fragilArray)
                                                    $fragil = "Si";
                                                else   
                                                    $fragil = "No";

                                                $perecederoArray = $arrayLista[$i]["perecedero"];
                                                if($perecederoArray)
                                                    $perecedero = "Si";
                                                else   
                                                    $perecedero = "No";

    
                                                echo "<tr><td align=center>" . $codigo . "</td>";
                                                echo "<td align=center>" . $dirRemitente . "</td>";
                                                echo "<td align=center>" . $dirEnvio . "</td>";
                                                echo "<td align=center>" . $fragil . "</td>";
                                                echo "<td align=center>" . $perecedero . "</td>";
                                                echo "<td align=center>" . $estado . "</td>";
                                                echo "<td align=center>" . $fechaPaquete . "</td>";
                                                echo "<td align=center>" . $ciTransportista . "</td>";
                                                echo "<td align=center>" . $fechaAsignacion . "</td>";
                                                echo "<td align=center><a href='inicio.php?m=2&n=$i'>Modificar</a></td>";
                                                echo "<td align=center><a href='inicio.php?m=2&n=$i&d=1'>Eliminar</a></td></tr>";
    
                                            }

                                            echo "</table>";


                                            if(isset($_GET["n"])){
                                            
                                                $numPaquete = $_GET["n"];

                                                if($arrayLista[$numPaquete]["estado"] == 'No asignado'){
                                                    
                                                    if(isset($_GET["d"])){

                                                        $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                        if($conexion == '1')
                                                            echo "Hubo un error al conectarnos a la base de datos";

                                                        $codigoPaquete = $arrayLista[$numPaquete]["codigo"];

                                                        eliminarPaquete($conexion, $codigoPaquete);

                                                    } else {
        
                                                        $codigo = $arrayLista[$numPaquete]["codigo"];
                                                        $dirRemitente = $arrayLista[$numPaquete]["dirRemitente"];
                                                        $dirEnvio = $arrayLista[$numPaquete]["dirEnvio"];
                                                        $fragil = $arrayLista[$numPaquete]["fragil"];
                                                        $perecedero = $arrayLista[$numPaquete]["perecedero"];


                                                        echo "<form method=POST name=modificar>";
                                                        echo "Codigo: <input type=text name=codigo placeholder='Ingresar codigo del paquete' value=$codigo required><br>";
                                                        echo "Dir. Remitente: <input type=text name=dirRemitente placeholder='Ingrese Dir. del Remitente' value=$dirRemitente required><br>";
                                                        echo "Dir. Envio: <input type=text name=dirEnvio placeholder='Ingrese Dir. de Envio' value=$dirEnvio required><br>";

                                                        if($fragil)
                                                            echo "Fragil: <input type=radio name=fragil value=1 checked required>Si " . "<input type=radio name=fragil value=0>No <br>";
                                                        else   
                                                            echo "Fragil: <input type=radio name=fragil value=1 required>Si " . "<input type=radio name=fragil value=0 checked>No <br>";

                                                        if($perecedero)
                                                            echo "Perecedero: <input type=radio name=perecedero value=1 checked required>Si " . "<input type=radio name=perecedero value=0>No <br>";
                                                        else   
                                                            echo "Perecedero: <input type=radio name=perecedero value=1 required>Si " . "<input type=radio name=perecedero value=0 checked>No <br>";
                                                        
                                                        echo "<input type=submit name=modificar id=modificar value='Modificar paquete'>";
                                                        echo "</form>";

                                                        if(array_key_exists("modificar", $_POST)){

                                                            if(!empty($_POST)) {
                                                    
                                                                $codigoPaquete = $arrayLista[$numPaquete]["codigo"];
                                                                $codigoModificado = $_POST["codigo"];
                                                                $dirRemitente = $_POST["dirRemitente"];
                                                                $dirEnvio = $_POST["dirEnvio"];
                                                                $fragil = $_POST["fragil"];
                                                                $perecedero = $_POST["perecedero"];

                                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                                if($conexion == '1')
                                                                    echo "Hubo un error al conectarnos a la base de datos";
        
                                                                modificarPaquete($conexion, $codigoPaquete, $codigoModificado, $dirRemitente, $dirEnvio, $fragil, $perecedero);
        
                                                    
                                                            } else {
                                                    
                                                                echo "No se encontraron datos.";
                                                            }
                                                            
                                                        }
    
                                                    }
                                                } else {

                                                    $ciTransportista = $arrayLista[$numPaquete]["ciTransportista"];
                                                    echo "El paquete que quiere actualizar ya esta asignado a un transportista, su cedula es $ciTransportista";
                                                }
                                            }
                                        }
                                    }

                                    if(isset($_GET["a"])){

                                        echo "<form method=POST name=agregar>";
                                        echo "Codigo: <input type=text name=codigo placeholder='Ingrese el codigo del paquete' required><br>";
                                        echo "Dir. Remitente: <input type=text name=dirRemitente placeholder='Ingrese Dir. de Remitente' required><br>";
                                        echo "Dir. Envio: <input type=text name=dirEnvio placeholder=Ingrese 'Ingrese Dir. de Envio' required><br>";
                                        echo "Fragil: <input type='radio' name='fragil' class='radio' value='1' checked required>Si " . "<input type='radio' name='fragil' class='radio' value='0'>No<br>";
                                        echo "Perecedero: <input type='radio' name='perecedero' class='radio' value='1' checked required>Si " . "<input type='radio' name='perecedero' class='radio' value='0'>No<br>";                                        
                                        echo "<input type=submit name=agregar id=agregar value='Agregar paquete'>";
                                        echo "</form>";

                                        if(array_key_exists("agregar", $_POST)){

                                            if(!empty($_POST)) {
                                    
                                                $codigoPaquete = $_POST["codigo"];
                                                $dirRemitente = $_POST["dirRemitente"];
                                                $dirEnvio = $_POST["dirEnvio"];
                                                $fragil = $_POST["fragil"];
                                                $perecedero = $_POST["perecedero"];

                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                if($conexion == '1')
                                                    echo "Hubo un error al conectarnos a la base de datos";

                                                agregarPaquete($conexion, $codigoPaquete, $dirRemitente, $dirEnvio, 1, 0);
                                    
                                            } else {
                                    
                                                echo "No se encontraron datos.";
                                            }
                                        }
                                    }
                                } else if ($metodo == 3){

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";
                                    
                                    $arrayLista = listaTransportistas($conexion);
    

                                    echo "<a href='inicio.php?m=3&a=1'>Agregar un transportista</a><br>";

                                    if($arrayLista != null){

                                        $cant_filas = count($arrayLista);
    
                                        if($cant_filas > 0){

                                            echo "<table border=1><tr>";
                                            echo "<tr><th align=center>Cedula</th>";
                                            echo "<th align=center>Nombres</th>";
                                            echo "<th align=center>Apellidos</th>";
                                            echo "<th align=center>Direccion</th>";
                                            echo "<th align=center>Telefono</th>";
                                            echo "<th align=center>Foto</th>";
                                            echo "<th align=center>Modificar</th>";
                                            echo "<th align=center>Eliminar</th></tr>";

                                            for($i = 0; $i < $cant_filas; $i++){

                                                $cedula = $arrayLista[$i]["cedula"];
                                                $nombres = $arrayLista[$i]["nombres"];
                                                $apellidos = $arrayLista[$i]["apellidos"];
                                                $direccion = $arrayLista[$i]["direccion"];
                                                $telefono = $arrayLista[$i]["telefono"];
                                                $foto = $arrayLista[$i]["foto"];

                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                if($conexion == '1'){
                                                    $msjBD = "Hubo un error al conectarnos a la base de datos";
                                                    echo '<div class="msj error">'.$msjBD.'</div>';
                                                } else {
                                                    
                                                    echo "<tr><td align=center>" . $cedula . "</td>";
                                                    echo "<td align=center>" . $nombres . "</td>";
                                                    echo "<td align=center>" . $apellidos . "</td>";
                                                    echo "<td align=center>" . $direccion . "</td>";
                                                    echo "<td align=center>" . $telefono . "</td>";
                                                    if(isset($foto))
                                                        echo "<td><img src='$foto' width=50 height=80 alt='Imagen no encontrada' /></td>";
                                                    else
                                                        echo "<td></td>";
                                                    echo "<td align=center><a href='inicio.php?m=3&n=$i'>Modificar</a></td>";
                                                    echo "<td align=center><a href='inicio.php?m=3&n=$i&d=1'>Eliminar</a></td></tr>";
                                                }
                                            }

                                            echo "</table>";


                                            if(isset($_GET["n"])){
                                            
                                                $numTransportista = $_GET["n"];
                                                
                                                $cedulaTransportista = $arrayLista[$numTransportista]["cedula"];

                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                if($conexion == '1')
                                                    echo "Hubo un error al conectarnos a la base de datos";
                                                $asignado = tienePaqueteAsignado($conexion, $cedula);

                                                if($asignado)
                                                    echo "El transportista tiene un paquete asignado, debe desasignarse o entregarlo para poder modificar o eliminar sus datos";
                                                else {
                                                    
                                                    if(isset($_GET["d"])){

                                                        $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                        if($conexion == '1')
                                                            echo "Hubo un error al conectarnos a la base de datos";

                                                        eliminarTransportista($conexion, $cedulaTransportista);

                                                    } else {
        
                                                        $cedula = $arrayLista[$numTransportista]["cedula"];
                                                        $nombres = $arrayLista[$numTransportista]["nombres"];
                                                        $apellidos = $arrayLista[$numTransportista]["apellidos"];
                                                        $direccion = $arrayLista[$numTransportista]["direccion"];
                                                        $telefono = $arrayLista[$numTransportista]["telefono"];
                                                        $foto = $arrayLista[$numTransportista]["foto"];


                                                        echo "<form method=POST name=modificar>";
                                                        echo "Cedula: <input type=text name=cedula placeholder='Ingresar cedula del transportista' value=$cedula required><br>";
                                                        echo "Nombres: <input type=text name=nombres placeholder='Ingrese nombres del transportista' value=$nombres required><br>";
                                                        echo "Apellidos: <input type=text name=apellidos placeholder='Ingrese apellidos del transportista' value=$apellidos required><br>";
                                                        echo "Direccion: <input type=text name=direccion placeholder='Ingresar direccion del transportista' value=$direccion required><br>";
                                                        echo "Telefono: <input type=text name=telefono placeholder='Ingrese telefono del transportista' value=$telefono required><br>";
                                                        echo "Foto: <input type='file' name='foto' src='$foto' width='70' height='100' alt='Imagen no encontrada' required><br>";
                                                                  
                                                        echo "<input type=submit name=modificar id=modificar value='Modificar datos de Transportista'><br>";
                                                        echo "</form>";

                                                        if(array_key_exists("modificar", $_POST)){

                                                            if(!empty($_POST)) {
                                                                                                                    
                                                                $cedulaModificada = $_POST["cedula"];
                                                                $nombres = $_POST["nombres"];
                                                                $apellidos = $_POST["apellidos"];
                                                                $direccion = $_POST["direccion"];
                                                                $telefono = $_POST["telefono"];
                                                                $foto = "";

                                                                if (is_uploaded_file($_FILES['foto']['tmp_name'])){
    
                                                                    if ($_FILES["foto"]["error"] > 0) {
                                                        
                                                                        echo "Error: " . $_FILES["foto"]["error"] . "<br>";
                                                                    } else {
                                                        
                                                                        $tmp_name = $_FILES["foto"]["tmp_name"];
                                                                        $ruta = 'C:/wamp/www/Obligatorio/Fotos/Transportista';
                                                                        $nombre =  $_FILES["foto"]["name"];
                                                                        $extension = explode ("." , $_FILES["foto"]["name"]);
                                                                        $extensionTipo = array('jpg','jpe','jpeg','png');
                                                        
                                                                        $subio = false;
                
                                                                        for($i = 0; $i < 4; $i++){
                                                        
                                                                            $tamanio = count($extension) - 1;
                                                                            if($extension[$tamanio] == $extensionTipo[$i]){

                                                                                $move = $ruta."//".$nombre;
                                                                                
                                                                                if(move_uploaded_file($tmp_name, $move))
                                                                                    $subio = true;
                                                                        
                                                                            }   
                                                                        }
                                                                        if (!$subio)
                                                                            echo "El tipo de archivo no es compatible";
                                                                        else 
                                                                            $foto = "C://wamp//www//Obligatorio//Fotos//Transportista//$nombre";
                                                        
                                                                    }
                                                                }

                                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                                if($conexion == '1')
                                                                    echo "Hubo un error al conectarnos a la base de datos";
        
                                                                modificarTransportista($conexion, $cedulaTransportista, $cedulaModificada, $nombres, $apellidos, $direccion, $telefono, ""); //Agregar foto
                                                    
                                                            } else {
                                                    
                                                                echo "No se encontraron datos.";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if(isset($_GET["a"])){

                                        echo "<form method=POST name=agregar enctype='multipart/form-data'>";
                                        echo "Cedula: <input type=text name=cedula placeholder='Ingresar cedula del transportista' required><br>";
                                        echo "Nombres: <input type=text name=nombres placeholder='Ingrese nombres del transportista' required><br>";
                                        echo "Apellidos: <input type=text name=apellidos placeholder='Ingrese apellidos del transportista' required><br>";
                                        echo "Direccion: <input type=text name=direccion placeholder='Ingresar direccion del transportista' required><br>";
                                        echo "Telefono: <input type=text name=telefono placeholder='Ingrese telefono del transportista' required><br>";
                                        echo "PIN: <input type=text name=pin placeholder='Ingrese PIN para iniciar su sesion' required><br>";
                                        echo "Foto: <input type='file' name='foto' required><br>";
                                                    
                                        echo "<input type=submit name=agregar id=agregar value='Agregar Transportista'><br>";
                                        echo "</form>";

                                        if(array_key_exists("agregar", $_POST)){

                                            if(!empty($_POST)) {
                                    
                                                $cedulaTransportista = $_POST["cedula"];
                                                $nombres = $_POST["nombres"];
                                                $apellidos = $_POST["apellidos"];
                                                $direccion = $_POST["direccion"];
                                                $telefono = $_POST["telefono"];
                                                $pin = $_POST["pin"];
                                                $foto = "";

                                                if (is_uploaded_file($_FILES['foto']['tmp_name'])){
    
                                                    if ($_FILES["foto"]["error"] > 0) {
                                        
                                                        echo "Error: " . $_FILES["foto"]["error"] . "<br>";
                                                    } else {
                                        
                                                        $tmp_name = $_FILES["foto"]["tmp_name"];
                                                        $ruta = 'C:/wamp/www/Obligatorio/Fotos/Transportista';
                                                        $nombre =  $_FILES["foto"]["name"];
                                                        $extension = explode ("." , $_FILES["foto"]["name"]);
                                                        $extensionTipo = array('jpg','jpe','jpeg','png');
                                        
                                                        $subio = false;

                                                        for($i = 0; $i < 4; $i++){
                                        
                                                            $tamanio = count($extension) - 1;
                                                            if($extension[$tamanio] == $extensionTipo[$i]){
                                                                
                                                                $move = $ruta."/".$nombre;
                                                                                
                                                                if(move_uploaded_file($tmp_name, $move))
                                                                    $subio = true;
                                                        
                                                            }   
                                                        }
                                                        if (!$subio)
                                                            echo "El tipo de archivo no es compatible";
                                                        else 
                                                            $foto = 'Fotos/Transportista/' . $nombre;
                                        
                                                    }
                                                }

                                                $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                                if($conexion == '1')
                                                    echo "Hubo un error al conectarnos a la base de datos";

                                                agregarTransportista($conexion, $cedulaTransportista, $nombres, $apellidos, $direccion, $telefono, $foto, $pin);
                                    
                                            } else {
                                    
                                                echo "No se encontraron datos.";
                                            }
                                        }
                                    }
                                }  else if($metodo == 4) {

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "Hubo un error al conectarnos a la base de datos";
                                    
                                    $arrayHistorial = historialPaquetes($conexion);
        
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
                                        echo "No hay paquetes entregados o por entregar";
                                } 
                            }   
                        }
                        ?>

                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            
            
        </main>



        <!-- FOOTER -->
        <?php //include('footer.php') Lo saco porque si se va a agregar un paquete, etc y ya hay varios no deja apretar el boton jajaja?>


    </div>
  </body>
</html>
