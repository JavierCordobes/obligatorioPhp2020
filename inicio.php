
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
                        

                        <!-- acá va el contenido -->
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
                        </table>





                    </div>
                </div>
            </div>
            



            
        </main>



        <!-- FOOTER -->
        <?php include('footer.php') ?>



    </div>
  </body>
</html>
