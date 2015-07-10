function validaForma() {
	var validacion = true;

	if ($('#productos').val() == "") {
		$('label[for="productos"]').addClass("error");
		$('#errores ul').append("<li>El producto no puede ser vacío</li>");
		validacion = false;
	} else
		$('label[for="productos"]').removeClass("error");
		
	if ($('#temporalidades').val() == "") {
		$('label[for="temporalidades"]').addClass("error");
		$('#errores ul').append("<li>La temporalidad no puede ser vacía</li>");
		validacion = false;
	} else
		$('label[for="temporalidades"]').removeClass("error");
	
	if ($('#nombre').val() == "") {
		$('label[for="nombre"]').addClass("error");
		$('#errores ul').append("<li>El nombre no puede ser vacío</li>");
		validacion = false;
	} else
		$('label[for="nombre"]').removeClass("error");
	
	if ($('#institucion').val() == "") {
		$('label[for="institucion"]').addClass("error");
		$('#errores ul').append("<li>La institución no puede ser vacía</li>");
		validacion = false;
	} else
		$('label[for="institucion"]').removeClass("error");
	
	if ($('#formato').val() == "") {
		$('label[for="formato"]').addClass("error");
		$('#errores ul').append("<li>El formato no puede ser vacío</li>");
		validacion = false;
	} else
		$('label[for="institucion"]').removeClass("error");
	
	if ($('#correo').val() == "") {
		$('label[for="correo"]').addClass("error");
		$('#errores ul').append("<li>El correo no puede ser vacío</li>");
		validacion = false;
	} else {
		$.ajax({
			url : "./acciones.php",
			data : {
				correo : $('#correo').val()
			}
		}).done(function(valido) {
			if (valido == "1") {
				$('label[for="correo"]').removeClass("error");
			} else if (valido == "0") {
				$('label[for="correo"]').addClass("error");
				$('#errores ul').append("<li>El correo no es válido</li>");
				validacion = false;
			}
		});
	}
	
	if ($('#objetivo').val() == '') {
		$('label[for="objetivo"]').addClass("error");
		$('#errores ul').append("<li>El objetivo no puede ser vacío</li>");
		validacion = false;
	} else
		$('label[for="objetivo"]').removeClass("error");
		
	
	// Latitudes y longitudes
	if ($('#latitud_1').val() == '') {
		$('label[for="latitud_1"]').addClass("error");
		$('#errores ul').append("<li>La latitud 1 no puede ser vacía</li>");
		validacion = false;
	} else if (parseInt($('#latitud_1').val()) > 33) {
		$('label[for="latitud_1"]').addClass("error");
		$('#errores ul').append("<li>La latitud 1 no puede ser mayor a 33</li>");
		validacion = false;
	} else
		$('label[for="latitud_1"]').removeClass("error");
	
	if ($('#longitud_1').val() == '') {
		$('label[for="longitud_1"]').addClass("error");
		$('#errores ul').append("<li>La longitud 1 no puede ser vacía</li>");
		validacion = false;
	} else if (parseInt($('#longitud_1').val()) < -122) {
		$('label[for="longitud_1"]').addClass("error");
		$('#errores ul').append("<li>La longitud 1 no puede ser mayor a 33</li>");
		validacion = false;
	} else
		$('label[for="longitud_1"]').removeClass("error");
	
	if ($('#latitud_2').val() == '') {
		$('label[for="latitud_2"]').addClass("error");
		$('#errores ul').append("<li>La latitud 2 no puede ser vacía</li>");
		validacion = false;
	} else if (parseInt($('#latitud_2').val()) > 33) {
		$('label[for="latitud_2"]').addClass("error");
		$('#errores ul').append("<li>La latitud 2 no puede ser mayor a 33</li>");
		validacion = false;
	} else
		$('label[for="latitud_2"]').removeClass("error");
	
	if ($('#longitud_2').val() == '') {
		$('label[for="longitud_2"]').addClass("error");
		$('#errores ul').append("<li>La longitud 2 no puede ser vacía</li>");
		validacion = false;
	} else if (parseInt($('#longitud_2').val()) < -122) {
		$('label[for="longitud_2"]').addClass("error");
		$('#errores ul').append("<li>La longitud 2 no puede ser mayor a 33</li>");
		validacion = false;
	} else
		$('label[for="longitud_2"]').removeClass("error");
	
	
	// Pasos diarios y prmedios diarios, (calendario)
	if ($('#fecha_inicio').val() != undefined
			&& $('#fecha_fin').val() != undefined) {
		var fecha_inicio = parseInt($('#fecha_inicio').val().replace(/-/g, ''));
		var fecha_fin = parseInt($('#fecha_fin').val().replace(/-/g, ''));
		
		// Para la fecha de inicio
		if ($('#fecha_inicio').val() == "")
		{
			$('label[for="fecha_inicio"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser vacía</li>");
			validacion = false;
		} else if (fecha_inicio < 20020701 || fecha_inicio > 20131231) {
			$('label[for="fecha_inicio"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser menor a 2002/07/01 ni mayor a 2013/12/31</li>");
			validacion = false;
		} else if (fecha_inicio > fecha_fin) {
			$('label[for="fecha_inicio"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser mayor que la fecha de termino</li>");
			validacion = false;
		} else $('label[for="fecha_inicio"]').removeClass("error");
			
		// Para la fecha de termino
		if ($('#fecha_fin').val() == "")
		{
			$('label[for="fecha_fin"]').addClass("error");
			$('#errores ul').append("<li>La fecha de termino no puede ser vacía</li>");
			validacion = false;
		} else if (fecha_fin < 20020701 || fecha_fin > 20131231) {
			$('label[for="fecha_fin"]').addClass("error");
			$('#errores ul').append("<li>La fecha de termino no puede ser menor a 2002/07/01 ni mayor a 2013/12/31</li>");
			validacion = false;
		} else if (fecha_inicio > fecha_fin) {
			$('label[for="fecha_fin"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser mayor que la fecha de termino</li>");
			validacion = false;
		} else
			$('label[for="fecha_fin"]').removeClass("error");
		
		
	
	// Compuestos 8 dias, anomalias 8 dias (anio y 46 semanas)
	} else if ($('#anio_inicio').val() != undefined && $('#anio_fin').val() != undefined && $('#semana_inicio').val() != undefined && $('#semana_fin').val() != undefined) {
		
		// Verifica que no sean vacios
		if ($('#anio_inicio').val() == "")
		{
			$('label[for="anio_inicio"]').addClass("error");
			$('#errores ul').append("<li>El año de inicio no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="anio_inicio"]').removeClass("error");
		
		if ($('#anio_fin').val() == "")
		{
			$('label[for="anio_fin"]').addClass("error");
			$('#errores ul').append("<li>El año de termino no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="anio_fin"]').removeClass("error");
		
		if ($('#semana_inicio').val() == "")
		{
			$('label[for="semana_inicio"]').addClass("error");
			$('#errores ul').append("<li>La semana de inicio no puede ser vacía</li>");
			validacion = false;
		} else
			$('label[for="semana_inicio"]').removeClass("error");
		
		if ($('#semana_fin').val() == "")
		{
			$('label[for="semana_fin"]').addClass("error");
			$('#errores ul').append("<li>La semana de termino no puede ser vacía</li>");
			validacion = false;
		} else
			$('label[for="semana_fin"]').removeClass("error");
		
		var fecha_inicio = $('#anio_inicio').val() + $('#semana_inicio').val();
		var fecha_fin = $('#anio_fin').val() + $('#semana_fin').val();
		
		// Fechas invalidas
		if (fecha_inicio > fecha_fin)
		{
			$('label[for="anio_inicio"]').addClass("error");
			$('label[for="semana_inicio"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser mayor que la fecha de termino</li>");
			validacion = false;
		} else if ($('#anio_inicio').val() != "" && $('#semana_inicio').val() != "") {
			$('label[for="anio_inicio"]').removeClass("error");
			$('label[for="semana_inicio"]').removeClass("error");
		}		

	// Compuestos 8 dias, anomalias 8 dias (anio y 46 semanas)
	} else if ($('#anio_inicio').val() != undefined && $('#anio_fin').val() != undefined && $('#mes_inicio').val() != undefined && $('#mes_fin').val() != undefined) {
		
		// Verifica que no sean vacios
		if ($('#anio_inicio').val() == "")
		{
			$('label[for="anio_inicio"]').addClass("error");
			$('#errores ul').append("<li>El año de inicio no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="anio_inicio"]').removeClass("error");
		
		if ($('#anio_fin').val() == "")
		{
			$('label[for="anio_fin"]').addClass("error");
			$('#errores ul').append("<li>El año de termino no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="anio_fin"]').removeClass("error");
		
		if ($('#mes_inicio').val() == "")
		{
			$('label[for="mes_inicio"]').addClass("error");
			$('#errores ul').append("<li>El mes de inicio no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="mes_inicio"]').removeClass("error");
		
		if ($('#mes_fin').val() == "")
		{
			$('label[for="mes_fin"]').addClass("error");
			$('#errores ul').append("<li>El año de termino no puede ser vacío</li>");
			validacion = false;
		} else 
			$('label[for="mes_fin"]').removeClass("error");
		
		var fecha_inicio = $('#anio_inicio').val() + $('#mes_inicio').val();
		var fecha_fin = $('#anio_fin').val() + $('#mes_fin').val();
		
		// Fechas invalidas
		if (fecha_inicio > fecha_fin)
		{
			$('label[for="anio_inicio"]').addClass("error");
			$('label[for="mes_inicio"]').addClass("error");
			$('#errores ul').append("<li>La fecha de inicio no puede ser mayor que la fecha de termino</li>");
			validacion = false;
		} else if ($('#anio_inicio').val() != "" && $('#mes_inicio').val() != "") {
			$('label[for="anio_inicio"]').removeClass("error");
			$('label[for="mes_inicio"]').removeClass("error");
		}		
	
	// climatologias mensuales (mes)
	} else if($('#mes_inicio').val() != undefined && $('#mes_fin').val() != undefined) {
		if ($('#mes_inicio').val() == "")
		{
			$('label[for="mes_inicio"]').addClass("error");
			$('#errores ul').append("<li>El mes de inicio no puede ser vacío</li>");
			validacion = false;
		} else
			$('label[for="mes_inicio"]').removeClass("error");
		
		if ($('#mes_fin').val() == "")
		{
			$('label[for="mes_fin"]').addClass("error");
			$('#errores ul').append("<li>El mes de termino no puede ser vacío</li>");
			validacion = false;
		} else 
			$('label[for="mes_fin"]').removeClass("error");
		
		
		// Mes invalido
		if ($('#mes_inicio').val() > $('#mes_fin').val())
		{
			$('label[for="mes_inicio"]').addClass("error");
			$('#errores ul').append("<li>El mes de inicio no puede ser mayor que el mes de termino</li>");
			validacion = false;
		} else if ($('#mes_inicio').val() != "")
			$('label[for="mes_inicio"]').removeClass("error");
	
	// climatologias de 8 dias (semana)	
	} else if($('#semana_inicio').val() != undefined && $('#semana_fin').val() != undefined) {
		if ($('#semana_inicio').val() == "")
		{
			$('label[for="semana_inicio"]').addClass("error");
			$('#errores ul').append("<li>La semana de inicio no puede ser vacía</li>");
			validacion = false;
		} else
			$('label[for="semana_inicio"]').removeClass("error");
		
		if ($('#semana_fin').val() == "")
		{
			$('label[for="semana_fin"]').addClass("error");
			$('#errores ul').append("<li>La semana de termino no puede ser vacía</li>");
			validacion = false;
		} else 
			$('label[for="semana_fin"]').removeClass("error");
		
		
		// Mes invalido
		if ($('#semana_inicio').val() > $('#semana_fin').val())
		{
			$('label[for="semana_inicio"]').addClass("error");
			$('#errores ul').append("<li>La semana de inicio no puede ser mayor que la semana de termino</li>");
			validacion = false;
		} else if ($('#mes_inicio').val() != "")
			$('label[for="semana_inicio"]').removeClass("error");
	}
	

	if (validacion)
	{	
		$('#errores').hide();
		return true;
	} else {
		$('#errores').show();
		return false;
	}
}

$(document).on(
		'ready',
		function() {
			$('.productos').change(
					function() {
						$.ajax({
							url : "./acciones.php",
							data : {
								producto : $(this).val()
							}
						}).done(
								function(opciones) {
									if (opciones != "0") {
										$('#temporalidad').empty().append(
												opciones)
												.removeAttr('disabled');
										$('#fecha').empty();
									} else {
										$('#temporalidad').val('').attr(
												'disabled', 'disabled');
										$('#fecha').empty();
									}
								});
					});

			$('#temporalidad').change(function() {
				$.ajax({
					url : "./acciones.php",
					data : {
						temporalidad : $(this).val()
					}
				}).done(function(html) {
					if (html != "0") {
						$('#fecha').empty().html(html);
					} else {
						$('#fecha').empty();
					}
				});
			});

			$(document).on(
					'change',
					'#anio_inicio, #anio_fin',
					function() {
						// if ($(this).val() == '2002')
						// {
						var identificador = $(this).attr('id');
						var numero = identificador.substring(5);

						if ($('#semana_inicio').val() == undefined
								|| $('#semana_fin').val() == undefined)
							var cual = 'mes';
						else
							var cual = 'semana';

						if (numero == 'inicio')
							numero = 1
						else
							numero = 2

						$.ajax({
							url : "./acciones.php",
							data : {
								anio : $(this).val(),
								cual : cual,
								numero : numero
							}
						}).done(
								function(html) {
									if (html != "0") {
										$(
												'#'
														+ cual
														+ '_'
														+ identificador
																.substring(5))
												.replaceWith(html);
									} else {
										$('#fecha').empty();
									}
								});
						// }
					});

			$('#latitud_1').change(
					function() {
						if (parseFloat($(this).val()) > 33
								|| isNaN(parseFloat(($(this).val())))) {
							$(this).val("33.0");
						}
					});

			$('#latitud_2').change(
					function() {
						if (parseFloat($(this).val()) < 3
								|| isNaN(parseFloat(($(this).val())))) {
							$(this).val("3.0");
						}
					});

			$('#longitud_1').change(
					function() {
						if (parseFloat($(this).val()) < -122
								|| isNaN(parseFloat(($(this).val())))) {
							$(this).val("-122.0");
						}
					});

			$('#longitud_2').change(
					function() {
						if (parseFloat($(this).val()) > -72
								|| isNaN(parseFloat(($(this).val())))) {
							$(this).val("-72.0");
						}
					});
		});
