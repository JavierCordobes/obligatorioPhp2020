<?php

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

                echo "<div class='msj ok'>Estado del paquete: $estadoPaquete</div><br>";

                if(!empty($arrayPaquete["fechaPaquete"])){

                    $fechaArray = $arrayPaquete["fechaPaquete"];
                    $timestamp = strtotime($fechaArray);
                    $fechaPaquete = date("d/m/Y", $timestamp);

                    if($estadoPaquete == "Asignado")
                        echo "<div class='msj ok'>Fecha estimada de entrega: $fechaPaquete</div>";
                    else
                        echo "<div class='msj ok'>Fecha de entrega: $fechaPaquete</div>";
                }
            } else 
                echo '<div class="msj error">'.$msjPaquete.'</div>';
        }
    }
}

?>