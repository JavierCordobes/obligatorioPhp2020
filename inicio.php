
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

                                            echo "<input name='estado' type='text' value='$estadoPaquete' readonly placeholder='Estado de Paquete'>";

                                            if(!empty($arrayPaquete["fechaPaquete"])){

                                                $fechaArray = $arrayPaquete["fechaPaquete"];

                                                $timestamp = strtotime($fechaArray);
                                                $fechaPaquete = date("Y-m-d", $timestamp);
                                                echo "<input name='fechaEstimada' type='date' value='$fechaPaquete' readonly placeholder='Fecha estimada de entrega'>";
                                            }
                                        }
                                    }
                                }

                            } else if ($tipo == "tr"){

                                echo "estoy en transportista";
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
