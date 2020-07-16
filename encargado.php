<?php 

if(!empty($_GET["m"])){

    $metodo = $_GET["m"];

    if($metodo == 1){

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

        $arrayPaquetesAsignados = paquetesAsignados($conexion);

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
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
        
        $arrayLista = listaPaquetes($conexion);


        echo "<a class='btn' href='inicio.php?m=2&a=1'>Agregar un paquete</a><br>";

        if($arrayLista != null){

            $cant_filas = count($arrayLista);

            if($cant_filas > 0){

                echo "<table><tr>";
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
                                echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                            $codigoPaquete = $arrayLista[$numPaquete]["codigo"];

                            eliminarPaquete($conexion, $codigoPaquete);

                        } else {

                            $codigo = $arrayLista[$numPaquete]["codigo"];
                            $dirRemitente = $arrayLista[$numPaquete]["dirRemitente"];
                            $dirEnvio = $arrayLista[$numPaquete]["dirEnvio"];
                            $fragil = $arrayLista[$numPaquete]["fragil"];
                            $perecedero = $arrayLista[$numPaquete]["perecedero"];


                            echo "
                            <form method=POST name=modificar>
                            <span>Codigo:</span> 
                            <input type=text name=codigo placeholder='Ingresar codigo del paquete' value=$codigo maxlength=16 required><br>
                            <span>Dir. Remitente:</span> 
                            <input type=text name=dirRemitente placeholder='Ingrese Dir. del Remitente' value=$dirRemitente maxlength=45 required><br>
                            <span>Dir. Envio:</span> 
                            <input type=text name=dirEnvio placeholder='Ingrese Dir. de Envio' value=$dirEnvio maxlength=45 required><br>";

                            if($fragil){
                                echo "<span>Fragil:</span> 
                                
                                <input class='radio' id='fragil1-si' type=radio name=fragil value=1 checked required>
                                <label class='radio' for='fragil1-si'>SI</label>
                        
                                <input class='radio' id='fragil1-no' type=radio name=fragil value=0>
                                <label class='radio' for='fragil1-no'>NO</label>";
                            
                            } else {   
                                echo "<span>Fragil:</span> 
                            
                                <input class='radio' id='fragil2-si' type=radio name=fragil value=1 required>
                                <label class='radio' for='fragil2-si'>SI</label>
                                
                                <input class='radio' id='fragil2-no' type=radio name=fragil value=0 checked>
                                <label class='radio' for='fragil2-no'>NO</label>";
                            }

                            if($perecedero){
                                echo "<span>Perecedero:</span> 
                                
                                <input id='perecedero1-si' type=radio name=perecedero value=1 checked required>
                                <label class='radio' for='perecedero1-si'>SI</label>
                                
                                <input id='perecedero1-no' type=radio name=perecedero value=0>
                                <label class='radio' for='perecedero1-no'>NO</label>";
                                
                            } else {
                                echo "<span>Perecedero:</span> 
                                
                                <input class='radio' type=radio id='perecedero2-si' name=perecedero value=1 required>
                                <label class='radio' for='perecedero2-si'>SI</label>
     
                                <input class='radio' type=radio id='perecedero2-no' name=perecedero value=0 checked>
                                <label class='radio' for='perecedero2-no'>NO</label>";
                            }

							echo "<input type=submit name=modificar id=modificar value='Modificar paquete'>
                            </form>";

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
                                        echo "
                                        <div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                                    if(!existePaquete($conexion, $codigoModificado))
                                        modificarPaquete($conexion, $codigoPaquete, $codigoModificado, $dirRemitente, $dirEnvio, $fragil, $perecedero);
                                    else{
                                        if($codigoModificado == $codigoPaquete)
                                            modificarPaquete($conexion, $codigoPaquete, $codigoModificado, $dirRemitente, $dirEnvio, $fragil, $perecedero);
                                        else
                                            echo "<div class='msj error'>Ya existe un paquete con ese codigo, por favor escoga uno diferente</div>";

                                    }
         
                                } else {
                        
                                    echo "<div class='msj error'>No se encontraron datos.</div>";
                                }
                            }
                        }
                    } else {

                        $ciTransportista = $arrayLista[$numPaquete]["ciTransportista"];
                        echo "<div class='msj error'>El paquete que quiere actualizar ya esta asignado a un transportista, su cedula es $ciTransportista</div>";
                    }
                }
            }
        }

        if(isset($_GET["a"])){

            echo "
            <form method=POST name=agregar>
            <span>Codigo:</span> 
            <input type=text name=codigo placeholder='Ingrese el codigo del paquete' maxlength=16 required><br>
            <span>Dir. Remitente:</span> 
            <input type=text name=dirRemitente placeholder='Ingrese Dir. de Remitente' maxlength=45 required>
            <span>Dir. Envio:</span> 
            <input type=text name=dirEnvio placeholder='Ingrese Dir. de Envio' maxlength=45 required><br>
            
            <span>Fragil:</span> 
           
            <input class='radio' id='fragil-agr-si' type=radio name=fragil value=1 checked required>
            <label class='radio' for='fragil-agr-si'>SI</label>
  
            <input class='radio' id='fragil-agr-no' type=radio name=fragil value=0>
            <label class='radio' for='fragil-agr-no'>NO</label>

            <span>Perecedero:</span> 
 
            <input id='perecedero-agr-si' class='radio' type=radio name=perecedero value=1 checked required>
            <label class='radio' for='perecedero-agr-si'>SI</label>		
			
            <input id='perecedero-agr-no' class='radio' type=radio name=perecedero value=0>       
            <label class='radio' for='perecedero-agr-no'>NO</label>


            <input type=submit name=agregar id=agregar value='Agregar paquete'>
            </form>";

            if(array_key_exists("agregar", $_POST)){

                if(!empty($_POST)) {
        
                    $codigoPaquete = $_POST["codigo"];
                    $dirRemitente = $_POST["dirRemitente"];
                    $dirEnvio = $_POST["dirEnvio"];
                    $fragil = $_POST["fragil"];
                    $perecedero = $_POST["perecedero"];

                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                    if($conexion == '1')
                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                    if(!existePaquete($conexion, $codigoPaquete))
                        agregarPaquete($conexion, $codigoPaquete, $dirRemitente, $dirEnvio, $fragil, $perecedero);
                    else
                        echo "<div class='msj error'>Ya existe un paquete con ese codigo, por favor escoga uno diferente</div>";
        
                } else {
        
                    echo "<div class='msj error'>No se encontraron datos.</div>";
                }
            }
        }
    } else if ($metodo == 3){

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
        
        $arrayLista = listaTransportistas($conexion);


        echo "<a class='btn' href='inicio.php?m=3&a=1'>Agregar un transportista</a><br>";

        if($arrayLista != null){

            $cant_filas = count($arrayLista);

            if($cant_filas > 0){

                echo "<table><tr>";
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
                    if($conexion == '1')
                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
                    else{
                        
                        echo "<tr><td align=center>" . $cedula . "</td>";
                        echo "<td align=center>" . $nombres . "</td>";
                        echo "<td align=center>" . $apellidos . "</td>";
                        echo "<td align=center>" . $direccion . "</td>";
                        echo "<td align=center>" . $telefono . "</td>";
                        if(!empty($foto))
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
                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
                    $asignado = tienePaqueteAsignado($conexion, $cedula);

                    if($asignado)
                        echo "<div class='msj error'>El transportista tiene un paquete asignado, debe desasignarse o entregarlo para poder modificar o eliminar sus datos</div>";
                    else {
                        
                        if(isset($_GET["d"])){

                            $conexion = crearConexion("localhost", "root", "", "obligatorio");
                            if($conexion == '1')
                                echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                            eliminarTransportista($conexion, $cedulaTransportista);

                        } else {

                            $cedula = $arrayLista[$numTransportista]["cedula"];
                            $nombres = $arrayLista[$numTransportista]["nombres"];
                            $apellidos = $arrayLista[$numTransportista]["apellidos"];
                            $direccion = $arrayLista[$numTransportista]["direccion"];
                            $telefono = $arrayLista[$numTransportista]["telefono"];
                            $foto = $arrayLista[$numTransportista]["foto"];


                            echo "
                            <form method=POST name=modificar enctype='multipart/form-data'>
                            <span>Cedula:</span> 
                            <input type=text name=cedula placeholder='Ingresar cedula del transportista' value=$cedula maxlength=15 required><br>
                            <span>Nombres:</span> 
                            <input type=text name=nombres placeholder='Ingrese nombres del transportista' value=$nombres maxlength=45 required><br>
                            <span>Apellidos:</span> 
                            <input type=text name=apellidos placeholder='Ingrese apellidos del transportista' value=$apellidos maxlength=45 required><br>
                            <span>Direccion:</span> 
                            <input type=text name=direccion placeholder='Ingresar direccion del transportista' value=$direccion maxlength=45 required><br>
                            <span>Telefono:</span> 
                            <input type=text name=telefono placeholder='Ingrese telefono del transportista' value=$telefono maxlength=45 required><br>
                            <span>Foto:</span> 
                            <input type='file' name='foto' width='70' height='100' alt='Imagen no encontrada'><br>
                                      
                            <input type=submit name=modificar id=modificar value='Modificar datos de Transportista'><br>;
                            </form>";

                            if(array_key_exists("modificar", $_POST)){

                                if(!empty($_POST)) {
                                                                                        
                                    $cedulaModificada = $_POST["cedula"];
                                    $nombres = $_POST["nombres"];
                                    $apellidos = $_POST["apellidos"];
                                    $direccion = $_POST["direccion"];
                                    $telefono = $_POST["telefono"];

                                    if(isset($_FILES["foto"])){

                                        if (is_uploaded_file($_FILES['foto']['tmp_name'])){

                                            if ($_FILES["foto"]["error"] > 0) {
                                
                                                echo "Error: " . $_FILES["foto"]["error"] . "<br>";
                                            } else {
                                
                                                $tmp_name = $_FILES["foto"]["tmp_name"];
                                                $ruta = 'C:/wamp/www/Obligatorio/Fotos/Transportista';
                                                $nombre =  $_FILES["foto"]["name"];
                                                $extension = explode ("." , $_FILES["foto"]["name"]);
                                                $tamanio = count($extension) - 1;
                                                $extensionTipo = array('jpg','jpe','jpeg','png');

                                                $subio = false;
                                                for($i = 0; $i < 4; $i++){
                                
                                                    if($extension[$tamanio] == $extensionTipo[$i]){
    

                                                        $move = $ruta . '/' . $cedulaModificada . '.' . $extensionTipo[$i];
                                                        
                                                        if(move_uploaded_file($tmp_name, $move)){
                                                            $subio = true;
                                                            $extension = $extensionTipo[$i];
                                                        }
                                                
                                                    }
                                                }
                                                if (!$subio)
                                                    echo "<div class='msj error'>El tipo de archivo no es compatible</div>";
                                                else 
                                                    $foto = 'Fotos/Transportista/' . $cedulaModificada . '.' . $extension;
                                
                                            }
                                        }
                                    } else 
                                        $foto = "";

                                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                                    if($conexion == '1')
                                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                                    if(!existeTransportista($conexion, $cedulaModificada))
                                        modificarTransportista($conexion, $cedulaTransportista, $cedulaModificada, $nombres, $apellidos, $direccion, $telefono, $foto); 
                                    else{
                                        if($cedulaModificada == $cedulaTransportista)
                                            modificarTransportista($conexion, $cedulaTransportista, $cedulaModificada, $nombres, $apellidos, $direccion, $telefono, $foto); 
                                        else    
                                            echo "<div class='msj error'>Ya existe un transportista con esa cedula</div>";
                                    }
                        
                                } else {
                        
                                    echo "<div class='msj error'>No se encontraron datos</div>";
                                }
                            }
                        }
                    }
                }
            }
        }

        if(isset($_GET["a"])){

            echo"
            <form method=POST name=agregar enctype='multipart/form-data'>
	            <span>Cedula:</span>
	            <input type=text name=cedula placeholder='Ingresar cedula del transportista' maxlength=15 required><br>
	            <span>Nombres:</span> 
	            <input type=text name=nombres placeholder='Ingrese nombres del transportista' maxlength=45 required><br>
	            <span>Apellidos:</span> 
	            <input type=text name=apellidos placeholder='Ingrese apellidos del transportista' maxlength=45 required><br>
	            <span>Direccion:</span> 
	            <input type=text name=direccion placeholder='Ingresar direccion del transportista' maxlength=45 required><br>
	            <span>Telefono:</span> 
	            <input type=text name=telefono placeholder='Ingrese telefono del transportista' maxlength=45 required><br>
	            <span>PIN:</span> 
	            <input type=text name=pin placeholder='Ingrese PIN para iniciar su sesion' maxlength=6 required><br>
	            <span>Foto:</span> 
	            <input type='file' name='foto' required><br>
	                        
	            <input type=submit name=agregar id=agregar value='Agregar Transportista'><br>
            </form>";

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
                            $ruta = 'C:/wamp/www/obligatorio/Fotos/Transportista';
                            $nombre =  $_FILES["foto"]["name"];
                            $extension = explode ("." , $_FILES["foto"]["name"]);
                            $extensionTipo = array('jpg','jpe','jpeg','png');
            
                            $subio = false;

                            for($i = 0; $i < 4; $i++){
            
                                $tamanio = count($extension) - 1;
                                if($extension[$tamanio] == $extensionTipo[$i]){
                                    
                                    $move = $ruta . '/' . $cedulaTransportista . "." . $extensionTipo[$i];
                                                    
                                    if(move_uploaded_file($tmp_name, $move)){
                                        
                                        $extension = $extensionTipo[$i];
                                        $subio = true;
                                    }
                                }   
                            }
                            if (!$subio)
                                echo "<div class='msj error'>El tipo de archivo no es compatible</div>";
                            else 
                                $foto = 'Fotos/Transportista/' . $cedulaTransportista . '.' . $extension;
            
                        }
                    }

                    $conexion = crearConexion("localhost", "root", "", "obligatorio");
                    if($conexion == '1')
                        echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";

                    if(!existeTransportista($conexion, $cedulaTransportista))
                        agregarTransportista($conexion, $cedulaTransportista, $nombres, $apellidos, $direccion, $telefono, $foto, $pin);
                    else
                        echo "<div class='msj error'>Ya existe un transportista con esa cedula</div>";

                } else {
        
                    echo "<div class='msj error'>No se encontraron datos.</div>";
                }
            }
        }
    }  else if($metodo == 4) {

        $conexion = crearConexion("localhost", "root", "", "obligatorio");
        if($conexion == '1')
            echo "<div class='msj error'>Hubo un error al conectarnos a la base de datos</div>";
        
        $arrayHistorial = historialPaquetes($conexion);

        if($arrayHistorial != null){

            if(isset($arrayHistorial[0])){
                $cant_filas0 = count($arrayHistorial[0]);

                if($cant_filas0 > 0){

                    echo "<table><tr>";
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
                
                        echo "<table><tr>";
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
                
                        echo "<table><tr>";
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
            echo "<div class='msj alerta'>No hay paquetes entregados o por entregar</div>";
    } 
}   

 ?>