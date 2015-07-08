function validaForma() {
	var validacion = true;
	var fecha_inicio = parseInt($('#fecha_inicio').val().replace(/-/g, ''));
	var fecha_fin = parseInt($('#fecha_fin').val().replace(/-/g, ''));

	// var patron_fecha_inicio=
	if ($('#productos').val() == "") {
		$('label[for="productos"]').addClass("error");
		validacion = false;
	} else {
		$('label[for="productos"]').removeClass("error");
	}
	if ($('#temporalidades').val() == "") {
		$('label[for="temporalidades"]').addClass("error");
		validacion = false;
	} else {
		$('label[for="temporalidades"]').removeClass("error");
	}
	if ($('#fecha_inicio').val() == "" || fecha_inicio < 20020701
			|| fecha_inicio > 20131231 || fecha_inicio > fecha_fin) {
		$('label[for="fecha_inicio"]').addClass("error");
		validacion = false;
	} else {
		$('label[for="fecha_inicio"]').removeClass("error");
	}
	if ($('#fecha_fin').val() == "" || fecha_fin < 20020701
			|| fecha_fin > 20131231 || fecha_inicio > fecha_fin) {
		$('label[for="fecha_fin"]').addClass("error");
		validacion = false;
	} else {
		$('label[for="fecha_fin"]').removeClass("error");
	}
	if ($('#nombre').val() == "") {
		$('label[for="nombre"]').addClass("error");
		validacion = false;
	} else {
		$('label[for="nombre"]').removeClass("error");
	}
        if ($('#institucion').val() == "") {
                $('label[for="institucion"]').addClass("error");
                validacion = false;
        } else {
                $('label[for="institucion"]').removeClass("error");
        }
	if ($('#correo').val() == "") {
		$('label[for="correo"]').addClass("error");
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
				validacion = false;
			}
		});
	}
	if ($('#objetivo').val() == '')
	{
		$('label[for="objetivo"]').addClass("error");
		validacion = false;
	}

	if (validacion) {
		return true;
	} else {
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
									} else {
										$('#temporalidad').val('').attr(
												'disabled', 'disabled');
									}
								});
					});
			
			$('#temporalidad').change(
					function() {
						$.ajax({
							url : "./acciones.php",
							data : {
								temporalidad : $(this).val()
							}
						}).done(
								function(html) {
									if (html != "0") {
										$('#fecha').empty().html(html);
									} else {
										$('#fecha').empty();
									}
								});
					});


			$('#latitud_1').change(function() {
				if (parseFloat($(this).val()) > 33 || isNaN(parseFloat(($(this).val())))) {
					$(this).val("33.0");
				}
			});

			$('#latitud_2').change(function() {
				if (parseFloat($(this).val()) < 3 || isNaN(parseFloat(($(this).val())))) {
					$(this).val("3.0");
				}
			});

			$('#longitud_1').change(function() {
				if (parseFloat($(this).val()) < -122 || isNaN(parseFloat(($(this).val())))) {
					$(this).val("-122.0");
				}
			});

			$('#longitud_2').change(function() {
				if (parseFloat($(this).val()) > -72 || isNaN(parseFloat(($(this).val())))) {
					$(this).val("-72.0");
				}
			});
		});
