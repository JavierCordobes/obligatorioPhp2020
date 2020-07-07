<header id="header">
	<div class="container">
		<div class="row">
			


			<div class="col-8">

				<?php 

				if($tipo != "vs"){
			
					if($tipo == "en"){
			
					
						echo "<p class='tipo-user'>Tipo de usuario: Encargado</p>";

						echo "<!-- menú -->";
						echo "<nav>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=1'>Inicio</a>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=2'>ABM de paquetes</a>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=3'>ABM de transportistas</a>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=4'>Historial de envios</a>";
						echo "</nav>";

					}
					

					if($tipo == "tr"){
			
					
						echo "<p class='tipo-user'>Tipo de usuario: Transportista</p>";

						echo "<!-- menú -->";
						echo "<nav>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=1'>Inicio</a>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=5'>Asignacion de paquetes</a>";
							echo "<a href='inicio.php?type=$tipo&ci=$ci&m=4'>Historial de envios</a>";
						echo "</nav>";
					}

				} else if($tipo == "vs") {
		
				
					echo "<p class='tipo-user'>Tipo de usuario: Visitante</p>";

					echo "<!-- menú -->";
					echo "<nav>";
						echo "<a href='inicio.php?type=$tipo'>Inicio</a>";
					echo "</nav>";

				} else {

					echo "Mostrar un mensaje de error";
				}
		
				?>
			</div>

			<div class="col-4 text-right">
				<p class="bienvenido">Bienvenido, <b> <?php echo "$nom"; ?></b></p>
				<a href="index.php" class="salir">Cerrar sesion</a>
			</div>


		</div>
	</div>
</header>