<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

class SATMO {
	private $temporalidades, $productos, $formatos, $correo, $nombre;

	public function __construct()
	{
		$temporalidades=array(
				'Temperatura superficial del mar'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2009)', 'Promedios Diarios'),
				'Temperatura superficial del mar nocturna'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2009)', 'Promedios Diarios'),
				'Temperatura superficial del mar 4 µm (nocturna) (nocturna)'=>array('pasos diarios', 'Compuestos 8 días',
						'Compuestos mensuales', 'Anomalías de Compuestos 8 días', 'Anomalías de Compuestos mensuales',
						'Climatologías 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2009)'),
				'Concentración de Clorofila a'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2009)', 'Promedios Diarios'),
				'Coeficiente de atenuación difusa a 488 nm'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Climatologías 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2009)'),
				'Material suspendido'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Climatologías 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2009)'),
				'Fluorescencia de clorofila'=>array('pasos diarios', 'Compuestos 8 días', 'Compuestos mensuales',
						'Climatologías 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2009)', 'Promedios Diarios'),
		);

		$formatos=array(
				'HDF',
				'GeoTiff',
				'PNG',
				'KMZ'
		);

		$this->temporalidades=$temporalidades;
		$this->productos=array_keys($temporalidades);
		$this->formatos=$formatos;
	}

	public function getTemporalidades($llave)
	{
		return $this->temporalidades[$llave];
	}

	public function selectProductos()
	{
		$select="<label for='productos'>Producto: </label><select name='producto' class='productos' id='productos'>";
		$select.="<option value=''>---Selecciona---</option>";
		foreach ($this->productos as $llave => $valor)
			$select.="<option value='".$valor."'>".$valor."</option>";

		return $select.'</select>';
	}

	public function selectFormatos()
	{
		$select="<label for='formato'>Formato: </label><select name='formato'>";
		foreach ($this->formatos as $llave => $valor)
			$valor == 'HDF' ? $select.="<option value='".$valor."' selected>".$valor."</option>" : $select.="<option value='".$valor."'>".$valor."</option>";

		return $select.'</select>';
	}

	public static function validaForma($parametros)
	{
		$errores='Tienes un error en los siguientes campos:<ul>';
		if (!isset($_POST['producto']) || empty($_POST['producto']))
			$errores.='<li>producto no puede ser vacío</li>';
		if (!isset($_POST['temporalidad']) || empty($_POST['temporalidad']))
			$errores.='<li>temporalidad no puede ser vacío</li>';
		if (!isset($_POST['fecha_inicio']) || empty($_POST['fecha_inicio']))
			$errores.='<li>La fecha de inicio no puede ser vacía</li>';
		if (!isset($_POST['fecha_fin']) || empty($_POST['fecha_fin']))
			$errores.='<li>La fecha de termino no puede ser vacía</li>';
		if (!isset($_POST['fecha_fin']) || empty($_POST['fecha_fin']))
			$errores.='<li>La fecha de termino no puede ser vacía</li>';
		if (!isset($_POST['latitud_1']) || empty($_POST['latitud_1']) || (int) $_POST['latitud_1'] > 33)
			$errores.='<li>latitud 1 no puede ser vacía o mayor a 33</li>';
		if (!isset($_POST['longitud_1']) || empty($_POST['longitud_1']) || (int) $_POST['longitud_1'] < -122)
			$errores.='<li>longitud 1 no puede ser vacía o menor a -122</li>';
		if (!isset($_POST['latitud_2']) || empty($_POST['latitud_2']) || (int) $_POST['latitud_2'] > 3)
			$errores.='<li>latitud 2 no puede ser vacía o mayor a 3</li>';
		if (!isset($_POST['longitud_2']) || empty($_POST['longitud_2']) || (int) $_POST['longitud_2'] < -72)
			$errores.='<li>longitud 1 no puede ser vacía o menor a -72</li>';
		if (!isset($_POST['formato']) || empty($_POST['formato']))
			$errores.='<li>producto no puede ser vacío</li>';
		if (!isset($_POST['nombre']) || empty($_POST['nombre']))
			$errores.='<li>nombre no puede ser vacío</li>';
		if (!isset($_POST['correo']) || empty($_POST['correo']))
			$errores.='<li>correo no puede ser vacío</li>';
		if (!self::validaCorreo($_POST['correo']))
			$errores.='<li>correo no tiene la estructura correcta</li>';

		if (preg_match('/<li>/', $errores)) {
			return $errores;
		} else {
			$limpia_nombre=str_replace(array(":", "/", "\\", "+", "]", "[", "(", ")", "\'", ".", ","), "", $_POST['nombre']);
			$_POST['nombre']=$limpia_nombre;
			$archivo=str_replace(' ', '_', $limpia_nombre);
			self::escribeArchivo('./archivos/'.date('Ymd-His').'_'.$archivo.'.txt', self::juntaDatos($_POST));
			return 'Tu petición fue enviada correctamente.';
		}
	}

	public static function juntaDatos($atributos)
	{
		$datos='';
		foreach ($atributos as $llave => $valor) {
			$datos.=$valor.',';
		}
		return substr($datos, 0, strlen($datos)-1);
	}

	public static function escribeArchivo($archivo, $cadena)
	{
		$fp = fopen($archivo,"w+") or die ("No se pudo escribir en el archivo");
		fputs($fp,"\xEF\xBB\xBF".$cadena);
		fclose($fp) or die ("No se pudo cerrar el archivo");
	}

	public static function validaCorreo($correo)
	{
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (preg_match($regex, $correo))
			return true;
		else
			return false;
	}
}