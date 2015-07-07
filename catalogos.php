<?php
/**
Carlos R. Alonso Torres
23112014
**/
ini_set('display_errors', 'On');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=UTF-8');
class SATMO {
	private $temporalidades, $productos, $formatos, $correo, $nombre;

	public function __construct()
	{
		$temporalidades=array(
				'Temperatura superficial del mar (11 µm) diurna (SST)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos de 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Temperatura superficial del mar (11 µm) nocturna (NSST)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos de 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Temperatura superficial del mar (4 µm) nocturna (SST4)'=>array('Pasos diarios', 'Compuestos de 8 días',
						'Compuestos mensuales', 'Anomalías de Compuestos de 8 días', 'Anomalías de Compuestos mensuales',
						'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)'),
				'Concentración de Clorofila-a (Chl_OC3 o CHLO)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Anomalías de Compuestos de 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Fluorescencia de la Clorofila (FLH)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Coeficiente de atenuación difusa a 488 nm (K_490)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)'),
				'Concentración de material total suspendido (TSM_Clark)'=>array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)'),
				
		);

		$formatos=array(
				'.HDF (con el valor georeferenciado. Proyección: Cilíndrica Equidistante. Datum: WGS84)',
				'.TIF (GeoTIFF con el valor georreferenciado. Proyección: Geográfica. Datum: WGS84)',
				'.PNG (vista rápida del producto con valores umbrales predefinidos y escala asociada)',
				'.KMZ (para visualizar en Google Earth con valores umbrales predefinidos y escala asociada)',
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
		$select="<label for='productos'>Seleccione el parámetro o producto oceánico: </label><select name='producto' class='productos' id='productos'>";
		$select.="<option value=''>---Selecciona---</option>";
		foreach ($this->productos as $llave => $valor)
			$select.="<option value='".$valor."'>".$valor."</option>";

		return $select.'</select>';
	}

	public function selectFormatos()
	{
		$select="<label for='formato'>Formato de la imagen: </label><br><select name='formato'>";
		$select.="<option value=''>---Selecciona---</option>";
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
		if (!isset($_POST['latitud_1']) || empty($_POST['latitud_1']) || (float) $_POST['latitud_1'] > 33.0)
			$errores.='<li>latitud 1 no puede ser vacía o mayor a 33.0</li>';
		if (!isset($_POST['longitud_1']) || empty($_POST['longitud_1']) || (float) $_POST['longitud_1'] < -122.0)
			$errores.='<li>longitud 1 no puede ser vacía o menor a -122.0</li>';
		if (!isset($_POST['latitud_2']) || empty($_POST['latitud_2']) || (float) $_POST['latitud_2'] < 3.0)
			$errores.='<li>latitud 2 no puede ser vacía o mayor a 3.0</li>';
		if (!isset($_POST['longitud_2']) || empty($_POST['longitud_2']) || (float) $_POST['longitud_2'] > -72.0)
			$errores.='<li>longitud 1 no puede ser vacía o menor a -72.0</li>';
		if (!isset($_POST['formato']) || empty($_POST['formato']))
			$errores.='<li>formato no puede ser vacío</li>';
		if (!isset($_POST['nombre']) || empty($_POST['nombre']))
			$errores.='<li>nombre no puede ser vacío</li>';
                if (!isset($_POST['institucion']) || empty($_POST['institucion']))
                        $errores.='<li>institucion no puede ser vacío</li>';
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
			$date = date('Ymd-His');
			self::escribeArchivo('./archivos/'.$date.'_'.$archivo.'.txt', self::juntaDatos($_POST));
			self::send_mail(self::juntaDatos($_POST, true), $date.'_'.$archivo.'.txt');
			return '<span class="Mtextoimport">Tu petición fue enviada correctamente.</span><br><br>';
		}
	}

	public static function juntaDatos($atributos, $email=false)
	{
		$columnas = array('producto' => 'Par&aacute;metro o producto oce&aacute;nico', 'temporalidad' => 'Temporalidad', 'fecha_inicio' => 'Desde', 'fecha_fin'
 => 'Al', 'latitud_1' => 'Latitud 1', 'longitud_1' => 'Longitud1', 'latitud_2' => 'Latitud2', 'longitud_2' => 'Longitud2', 'formato' => 'Formato', 'nombre' => 'Nombre solicitante', 'institucion' => 'Instituci&oacute;n', 'correo' => 'correo');
		$datos='';
		$datos_email='';
		foreach ($atributos as $llave => $valor)
		{
			$datos.=$valor.',';
			$datos_email.='<b>'.$columnas[$llave].':</b> '.$valor."<br>";
		}
	
		if ($email)
			return $datos_email;
		else
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

 	public static function send_mail ($mensaje, $archivo)
        {
		$para      = 'scerdeira@conabio.gob.mx, auribe@conabio.gob.mx';
		$titulo    = 'Solicitud de productos del SATMO';
		$mensaje   = $mensaje."<br><br>Baja el <a href=\"http://www.biodiversidad.gob.mx/pais/mares/satmo/solicitud_satmo/archivos/".$archivo."\" target=\"_blank\">archivo</a> directo del servidor.";
		$cabeceras = "Content-type: text/html; charset=utf-8"."\r\n";
		$cabeceras.= "From: noreply@conabio.gob.mx"."\r\n";
                mail($para, $titulo, $mensaje, $cabeceras);
        }
}
