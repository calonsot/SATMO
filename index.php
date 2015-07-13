<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<?php require 'catalogos.php'; ?>
<meta http-equiv="content-type" content="text/html" charset="UTF-8" />
<title>SATMO</title>
<link href="../../../../css/estilosgral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./js/SATMO.js"></script>
<style type="text/css">
.error {
	background-color: #619ED9;
} 
a:link {
	color: #EDE8CE;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-style: normal;
	line-height: 150%;
	color: #EDE8CE;
}
a:visited {
	color: #EDE8CE;
}
a:hover {
	color: #619ed9;
}
a:active {
	color: #619ed9;
}
input {
	-webkit-border-radius: 4px 4px 4px 4px;
	padding:3px;
	font-family:Verdana, Geneva, sans-serif;
}
select {
	-webkit-border-radius: 4px 4px 4px 4px;
	padding:3px;
	font-family:Verdana, Geneva, sans-serif;
}

-->
</style>

<style type="text/css">
      #map {
        width: 640px;
        height: 450px;
      }
</style>

<!--carga google maps y solo se puede hacer un rectangulo, devuelve las coordenadas-->
<!--Carlos R. Alonso Torres/09012014-->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">
      // Global variables
      var map;
      var marker1;
      var marker2;
      var rectangle;

      function validaCoordenadas() {
                        if (parseFloat($('#latitud_1').val()) > 33 || isNaN(parseFloat(($('#latitud_1').val())))) {
                                $('#latitud_1').val(33);
                        }

                        $('#latitud_2').change(function() {
                                if (parseFloat($(this).val()) < 3 || isNaN(parseFloat(($(this).val())))) {
                                        $(this).val(3);
                                }
                        });

                        $('#longitud_1').change(function() {
                                if (parseFloat($(this).val()) < -122 || isNaN(parseFloat(($(this).val())))) {
                                        $(this).val(-122);
                                }
                        });

                        $('#longitud_2').change(function() {
                                if (parseFloat($(this).val()) > -72 || isNaN(parseFloat(($(this).val())))) {
                                        $(this).val(-72);
                                }
                        });
      }

      /**
       * Updates the Rectangle's bounds to resize its dimensions.
       */
      function redraw() {
        var latLngBounds = new google.maps.LatLngBounds(
          marker1.getPosition(),
          marker2.getPosition()
        );
        rectangle.setBounds(latLngBounds);
      }

      /**
       * Called on the initial page load.
       */
      function init() {
        map = new google.maps.Map(document.getElementById('map'), {
          'zoom': 3,
          'center': new google.maps.LatLng(21.443796230317766, -101.085736328125),
          'mapTypeId': google.maps.MapTypeId.ROADMAP
        });

        // Plot two markers to represent the Rectangle's bounds.
        marker1 = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(33, -122),
          draggable: true,
          title: '�Arrastrame!'
        });
        marker2 = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(3, -72),
          draggable: true,
          title: '�Arrastrame!'
        });

        // Allow user to drag each marker to resize the size of the Rectangle.
        google.maps.event.addListener(marker1, 'drag', redraw);
        google.maps.event.addListener(marker2, 'drag', redraw);

        // Create a new Rectangle overlay and place it on the map.  Size
        // will be determined by the LatLngBounds based on the two Marker
        // positions.
        rectangle = new google.maps.Rectangle({
          map: map
        });

        google.maps.event.addListener(marker1, 'drag', function() {
                var position=marker1.getPosition().toString();
                var position_array=position.substring(1, position.length-1).split(',');
                if (parseFloat(position_array[0]) <= parseFloat(33.0) && parseFloat(position_array[0]) >= parseFloat(3.0)) {
                        $('#latitud_1').val(parseFloat(position_array[0]));
                }
                if (parseFloat(position_array[1]) >= parseFloat(-122.0) && parseFloat(position_array[1]) <= parseFloat(-72.0)) {
                        $('#longitud_1').val(parseFloat(position_array[1]));
                }
        });

        google.maps.event.addListener(marker2, 'drag', function() {
                var position=marker2.getPosition().toString();
                var position_array=position.substring(1, position.length-1).split(',');
                if (parseFloat(position_array[0]) >= parseFloat(3.0) && parseFloat(position_array[0]) <= parseFloat(33.0)) {
                        $('#latitud_2').val(parseFloat(position_array[0]));
                }
                if (parseFloat(position_array[1]) <= parseFloat(-72.0) && parseFloat(position_array[1]) >= parseFloat(-122.0)) {
                        $('#longitud_2').val(parseFloat(position_array[1]));
                }
        });

        redraw();

        $('#latitud_1, #longitud_1').change(function(){
                var latitud_1 = document.getElementById('latitud_1').value;
                var longitud_1 = document.getElementById('longitud_1').value;
                var latlng = new google.maps.LatLng(parseFloat(latitud_1), parseFloat(longitud_1));
                marker1.setPosition(latlng);
                redraw();
        });

        $('#latitud_2, #longitud_2').change(function(){
                var latitud_2 = document.getElementById('latitud_2').value;
                var longitud_2 = document.getElementById('longitud_2').value;
                var latlng = new google.maps.LatLng(parseFloat(latitud_2), parseFloat(longitud_2));
                marker2.setPosition(latlng);
                redraw();
        });

      }

      // Register an event listener to fire when the page finishes loading.
      google.maps.event.addDomListener(window, 'load', init);

    </script>

</head>

<body>
	<?php 
	if (isset($_GET['situacion']) && $_GET['situacion'] == 1 && isset($_POST) && !empty($_POST))
	{
		echo SATMO::validaForma($_POST);
	?>	
		<span class="Mtextoimport">Tus datos fueron enviados correctamente.</span>
	<?php } ?>
	
	<div id="errores" style="display: none;">
		Existe un error en la solicitud, por favor revisa los campos resaltados:
		<ul></ul>
	</div>
	
	<form action="index.php?situacion=1" method="post" class="Utextos">

		<?php 
		$SATMO=new SATMO();
		echo $SATMO->selectProductos();
		?>
		<br> <br>
      <label for="temporalidad">Temporalidad: </label> <select id="temporalidad" name="temporalidad" disabled="disabled">
			<option value="">---Selecciona---</option>
		</select>
        
        <p>
        	<div id="fecha"></div>	
		</p>
		
		<span class="Mtextoimport">Seleccione un &aacute;rea sobre el mapa o introduzca las coordenadas extremas:</span><br><span>Predeterminadas: Latitud N: (3 º y 33 º). Longitud W: (-122 º y -72 º)</span><br><label for="latitud_1">Latitud N: </label> <input
			type="text" name="latitud_1" value="33.0"
			id="latitud_1"> ºN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="longitud_1">Longitud W: </label> <input
			type="text" name="longitud_1" value="-122.0"
			id="longitud_1"> ºW<br> <label for="latitud_2">Latitud N: </label> <input
			type="text" name="latitud_2" value="3.0"
			id="latitud_2"> ºN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="longitud_2">Longitud W: </label> <input
			type="text" name="longitud_2" value="-72.0"
			id="longitud_2"> ºW<br> <br>
		<div id="map"></div><br><br>
		<?php echo $SATMO->selectFormatos(); ?>
		<br><br><label for="nombre">Nombre del solicitante: </label><input type="text" name="nombre" id="nombre" maxlength="255" size="45" placeholder="escribe tu nombre ..."/>
		<br><br><label for="institucion">Institución: </label><input type="text" name="institucion" id="institucion" maxlength="255" size="45" placeholder="escribe tu instituci&oacute;n ..."/>
		<br><br><label for="correo">Correo (para recibir instrucciones de descarga): </label><input type="email" name="correo" id="correo" maxlength="255" size="43" placeholder="escribe tu correo ..."/>
		<p>
			<label for="objetivo">Objetivo: </label>
			<textarea name="objetivo" id="objetivo" rows="8" cols="60" placeholder="Escribe el objetivo que tendra la petición de tus datos ..."></textarea>
		</p>
		<br> <br>
        <div align="right"><input type="submit" value="ENVIAR SU SOLICITUD" onclick="return validaForma();" style="font-weight:bold"></div>
	</form>
</body>
</html>

