<?php

if(isset($_POST['enviar'])){
 $codigo=$_POST['codigo'];

 $estado= $_POST['estado'];

 //echo($codigo.$fecha_estimada.$fecha_entrega.$estado);

 
    include 'Conexion_consulta_codigo.php';    
       
         
}
 

?>




<!DOCTYPE html>
<html>

<head>

 
<h1>Buscar por Codigo</h1>

<form action="ConsultaHistorial.php" method="post">
  <div class="form-group">
    <label for="codigo">Codigo</label>
    <input type="text" class="form-control" id="codigo" name="codigo"  placeholder="Codigo" required>
  
  </div>
  
  
  
 <div class="form-group">
 <label for="estado">Estado</label>
  <select  class="custom-select" id="estado" name="estado"  required>
  
  <option value="Sin Asignar">Sin Asignar</option>
  <option value="En transito">En transito</option>
  <option value="Enviado">Enviado</option>
</select>  
  </div>
  
 
  
    
   
    
  </fieldset>
 
  <button type="submit"name="enviar" class="btn btn-primary">Submit</button>
</form>
</div>


<div class="col-md-3">
</div>
   


<div class="col-md-6">
<h1> Paquetes</h1>
<br><br>
<table class="table table-bordered">
  <thead>
    <tr>
     
      <th scope="col">Codigo</th>
      <th scope="col">Fecha Estimada Entrega</th>
      <th scope="col">Fecha Entrega</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
  <tbody>
    
    <?php  while ($fila = mysqli_fetch_array($resultadouno)){
echo("<tr>");
echo ("<td>".$fila['Codigo']."</td>");
echo ("<td>".$fila['Fecha_estimada_entrega']."</td>");
echo ("<td>".$fila['Fecha_entrega']."</td>");
echo ("<td>".$fila['Estado']."</td>");
echo("</td>");
  
  }      ?>
    
  
    
   
  </tbody>
</table>


</div>
</div>
</div>















    
    
    
    
    
   
</body>

</html>