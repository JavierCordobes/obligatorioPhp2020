
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

        if(isset($_SESSION["tiempo"])){

            //tiempo en segundos para dar vida a la sesion
            $cierre = 3600;

            $vidaSesion = time() - $_SESSION["tiempo"];

            if($vidaSesion > $cierre){
                
                echo "<div class='msj alerta'>Se alcanzo el limite de 60 minutos</div>";
                echo "<meta http-equiv='refresh' content='1;url=inicio.php?m=10'>";
            }

        } 
        
            
        ?>


        

        <!-- MAIN -->
        <main id="main" role="main">
            <div class="container">
                <div class="row">
                    

                    <div class="col-md-12 text-center">
 
                        <?php
                        include_once('libreriaFunciones.php');


                        //VISITANTE
                        if($tipo == "vs"){

                            include('visitante.php');
                            
                        // TRANSPORTISTA
                        } else if ($tipo == "tr"){
                            
                            include('transportista.php');

                        // ENCARGADO
                        } else if ($tipo == "en"){

                            include('encargado.php');
                         
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
