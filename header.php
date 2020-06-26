<header id="header">
	<div class="container">
		<div class="row">
			

			
			


			<div class="col-8">

				<?php 
			
				if($tipo == "en"){
		
				
					echo "<p class='tipo-user'>Tipo de usuario: Encargado</p>";

					echo "<!-- menú -->";
					echo "<nav>";
						echo "<a href=''>Inicio</a>";
						echo "<a href=''>ABM de paquetes</a>";
						echo "<a href=''>ABM de transportistas</a>";
						echo "<a href=''>Historial de envios</a>";
						echo "</nav>";
				}
				

				if($tipo == "tr"){
		
				
					echo "<p class='tipo-user'>Tipo de usuario: Transportista</p>";

					echo "<!-- menú -->";
					echo "<nav>";
						echo "<a href=''>Inicio</a>";
						echo "<a href=''>ABM de paquetes</a>";
						echo "<a href=''>ABM de transportistas</a>";
						echo "<a href=''>Historial de envios</a>";
						echo "</nav>";
				}
		
				?>

			</div>




			<div class="col-4 text-right">
				<p class="bienvenido">Bienvenido <b>USUARIO</b></p>
				<!-- Hay que borrar las sesiones y eso cuando haya-->
				<a href="index.php" class="salir">Cerrar sesion</a>
			</div>


		</div>
	</div>
</header>