<?php
require 'catalogos.php';

if (isset($_GET['producto']) && $_GET['producto'] != '')
{
	$select="<option value=''>---Selecciona---</option>";
	$SATMO=new SATMO();
	$temporalidades=$SATMO->getTemporalidades($_GET['producto']);
	
	foreach ($temporalidades as $llave => $valor)
		// Para poner compuestos mensuales como seleccionado
		$select.="<option value='".$valor."'>".$valor."</option>";
	echo $select;

} elseif (isset($_GET['correo']) && $_GET['correo'] != '') {
	$es_valido=SATMO::validaCorreo($_GET['correo']);
	
	if ($es_valido)
		echo "1";
	else
		echo "0";

} elseif (isset($_GET['temporalidad']) && $_GET['temporalidad'] != '') {
	$SATMO=new SATMO();
	
	if (array_key_exists($_GET['temporalidad'], $SATMO->temporalidades_fechas))
	{
		$SATMO->temporalidad = $_GET['temporalidad'];
		$html = $SATMO->getFecha();
		echo $html;
	} else
		echo "0";	

} elseif (isset($_GET['anio']) && $_GET['anio'] != '' && isset($_GET['cual']) && $_GET['cual'] != '') {
	$SATMO=new SATMO();
	
	if ($_GET['cual'] == 'mes')
	{
		if ($_GET['anio'] != "2002")
			echo $SATMO->selectMeses((Int) $_GET['numero'], null, false);
		else	
			echo $SATMO->selectMeses((Int) $_GET['numero'], true, false);		
	} elseif ($_GET['cual'] == 'semana') {
		if ($_GET['anio'] != "2002")
			echo $SATMO->selectSemanas((Int) $_GET['numero'], null, false);
		else		
			echo $SATMO->selectSemanas((Int) $_GET['numero'], true, false);	
	} else
		echo "0";

} else
	echo "0";
