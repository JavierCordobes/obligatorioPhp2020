<?php 
  require('libreriaFunciones.php');
  include('head.php')  
?>

  <body class="body-login">
    <div id="cont">



        



      <div class="cont-login">
        <!-- form login -->
        <form class="login" action="" method="POST" name="login">
          
            <span>Tipo de usuario</span>
            <input name="tipo" type="radio" id="visitante" class="radio" value="vs">
            <label for="visitante" class="radio">VISITANTE</label>

            <input name="tipo" type="radio" id="transportista" class="radio" value="tr">
            <label for="transportista" class="radio">TRANSPORTISTA</label>
          
            <input name="tipo" type="radio" id="encargado" class="radio" value="en">
            <label for="encargado" class="radio">ENCARGADO</label>
            

            <span>Usuario</span>
            <input class="form-control" name="cedula" type="text" placeholder="Cedula">
            <span>Pin</span>
            <input class="form-control" name="pin" type="password"  placeholder="PIN">
           
            <input type="submit" name="ingresar" id="ingresar" value="INGRESAR">

        </form>



        <?php

        $conexion = conectarSQL();
        if(!$conexion){
          die("Error en la conexion al servidor");
        } 

        $conexionBD = conectarBD($conexion, "Obligatorio");
        if(!$conexionBD){
          die("Error en la conexion a la base de datos");
        } 

        if(array_key_exists("ingresar", $_POST)){
          if(!empty($_POST)) {

            $msjIngreso = "No se encontraron datos";
            if(!empty($_POST["tipo"])){
            
              $tipo = $_POST["tipo"];

              if($tipo == "vs"){

                ingreso("", "", $conexion, $tipo, $msjIngreso);
              } else {

                if(!empty($_POST["cedula"]) && !empty($_POST["pin"])){
                  $CI = $_POST["cedula"];
                  $PIN = $_POST["pin"];
                  ingreso($CI, $PIN, $conexion, $tipo, $msjIngreso);
                } else {
                  echo '<div class="msj error">'.$msjIngreso.'</div>';
                }
              }
            } else {
              $msjIngreso = "Debe ingresar el tipo de usuario.";
              echo '<div class="msj error">'.$msjIngreso.'</div>';
            }
          } else {
            echo '<div class="msj error">'.$msjIngreso.'</div>';
          }
   
          } 
          
        

        ?>
      
      </div>

    </div>
    
  </body>
</html>
