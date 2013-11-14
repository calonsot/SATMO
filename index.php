<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html" charset="UTF-8" />
<title>SATMO</title>
<script type="text/javascript"
	src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/SATMO.js"></script>
<style type="text/css">
.error {
	background-color: #FF0000;
}
</style>
</head>
<?php require 'catalogos.php'; ?>
<body>
	<?php 
	if (!empty($_POST))
	{
		echo SATMO::validaForma($_POST);
	}
	?>
	<form action="index.php" method="post">

		<?php 
		$SATMO=new SATMO();
		echo $SATMO->selectProductos();
		?>
		<br> <br> <label for="temporalidades">Temporalidades: </label> <select
			id="temporalidades" name="temporalidad" disabled="disabled">
			<option value="">---Selecciona---</option>
		</select> <br> <br> <label for="fecha_inicio">Escoge una fecha
			recolección de datos (Emieza desde el 1 de julio de 2002): </label><br>
		<input type="date" name="fecha_inicio" min="2002-07-01"
			max="2012-12-31" id="fecha_inicio"><br> <br> <label for="fecha_fin">Escoge
			una fecha de termino (Termina hasta el 31 de diciembre de 2012): </label>
		<br> <input type="date" name="fecha_fin" min="2002-07-01"
			max="2012-12-31" value="2012-12-31" id="fecha_fin"><br> <br>
		Coordenadas, solo se permiten rectangulos (predeterminado a toda la
		republica): <br> <label for="latitud_1">Latitud 1: </label> <input
			type="number" name="latitud_1" min="3" max="33" value="33"
			id="latitud_1"> <label for="latitud_1">Longitud 1: </label> <input
			type="number" name="longitud_1" min="-122" max="-72" value="-122"
			id="longitud_1"><br> <label for="latitud_2">Latitud 2: </label> <input
			type="number" name="latitud_2" min="3" max="33" value="3"
			id="latitud_2"> <label for="latitud_1">Longitud 2: </label> <input
			type="number" name="longitud_2" min="-122" max="-72" value="-72"
			id="longitud_2"><br> <br>
		<?php echo $SATMO->selectFormatos(); ?>
		<br><br><label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" maxlength="255" size="45" placeholder="escribe tu nombre ...">
		<br><br><label for="correo">Correo: </label><input type="email" name="correo" id="correo" maxlength="255" size="45" placeholder="escribe tu correo ...">

		<br> <br> <input type="submit" value="Enviar"
			onclick="return validaForma();">
	</form>
</body>
</html>

