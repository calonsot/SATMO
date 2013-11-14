<?php
require 'catalogos.php';

if (isset($_GET['producto']) && $_GET['producto'] != '')
{
	$select="<option value=''>---Selecciona---</option>";
	$SATMO=new SATMO();
	$temporalidades=$SATMO->getTemporalidades($_GET['producto']);
	foreach ($temporalidades as $llave => $valor)
		$valor == 'Compuestos mensuales' ? $select.="<option value='".$valor."' selected>".$valor."</option>" : $select.="<option value='".$valor."'>".$valor."</option>";
	echo $select;
} elseif (isset($_GET['correo']) && $_GET['correo'] != '') {
	$es_valido=SATMO::validaCorreo($_GET['correo']);
	if ($es_valido)
		echo "1";
	else
		echo "0";
} else
	echo "0";
