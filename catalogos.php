<?php
/**
Carlos R. Alonso Torres
23112014
**/
ini_set('display_errors', 'On');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=UTF-8');
class SATMO {
	public $temporalidades, $temporalidades_fechas, $temporalidad, $productos, $formatos, $correo, $nombre, $html;

	public function __construct()
	{
		$this->temporalidades=array(
				'Temperatura superficial del mar (11 µm) diurna (SST)' => array(
						'Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales', 'Anomalías de Compuestos de 8 días', 
						'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Temperatura superficial del mar (11 µm) nocturna (NSST)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
					    'Anomalías de Compuestos de 8 días', 'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)',
						'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Temperatura superficial del mar (4 µm) nocturna (SST4)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales', 'Anomalías de Compuestos de 8 días', 
						'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)'),
				'Concentración de Clorofila-a (Chl_OC3 o CHLO)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales', 'Anomalías de Compuestos de 8 días', 
						'Anomalías de Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'),
				'Fluorescencia de la Clorofila (FLH)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)', 
						'Climatologías mensuales (Jul.2002-Jun.2013)', 'Promedios Diarios'), 
				'Coeficiente de atenuación difusa a 488 nm (K_490)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales', 'Climatologías de 8 días (Jul.2002-Jun.2009)', 
						'Climatologías mensuales (Jul.2002-Jun.2013)'),
				'Concentración de material total suspendido (TSM_Clark)' => array('Pasos diarios', 'Compuestos de 8 días', 'Compuestos mensuales',
						'Climatologías de 8 días (Jul.2002-Jun.2009)', 'Climatologías mensuales (Jul.2002-Jun.2013)'),
				
		);
		
		/**
		 * Las fechas para las temporalidades son las mismas, asi que las puse en un array aparte
		 */
		$this->temporalidades_fechas = array(
						'Pasos diarios' => array('tipo_fecha' => 'calendario', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2013-12-31')), 
						'Compuestos de 8 días' => array('tipo_fecha' => 'semana', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2011-06-30')),
						'Compuestos mensuales' => array('tipo_fecha' => 'anio', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2013-12-31')),
						'Anomalías de Compuestos de 8 días' => array('tipo_fecha' => 'semana', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2009-06-30')),
						'Anomalías de Compuestos mensuales' => array('tipo_fecha' => 'anio', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2009-06-30')),
						'Climatologías de 8 días (Jul.2002-Jun.2009)' => array('tipo_fecha' => 'semana', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2009-06-30')),
						'Climatologías mensuales (Jul.2002-Jun.2013)' => array('tipo_fecha' => 'mes', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2013-06-30')),
						'Promedios Diarios' => array('tipo_fecha' => 'calendario', 'periodo' => array('inicio' => '2002-07-01', 'fin' => '2013-12-31'))
						);

		$this->formatos=array(
				'.HDF (con el valor georeferenciado. Proyección: Cilíndrica Equidistante. Datum: WGS84)',
				'.TIF (GeoTIFF con el valor georreferenciado. Proyección: Geográfica. Datum: WGS84)',
				'.PNG (vista rápida del producto con valores umbrales predefinidos y escala asociada)',
				/*
				 * De momento quitamos esta opcion
				 *///'.KMZ (para visualizar en Google Earth con valores umbrales predefinidos y escala asociada)',
		);

		$this->productos=array_keys($this->temporalidades);
	}

	/**
	 * Devuelve la temporalidad dependiendo el producto
	 * @param unknown $llave
	 * @return multitype:
	 */
	public function getTemporalidades($llave)
	{
		return $this->temporalidades[$llave];
	}
	
	/**
	 * Pone el calendario, las 46 semanas, los meses o un intervalo de anios.
	 */
	public function getFecha()
	{
		$datos = $this->temporalidades_fechas[$this->temporalidad];
		
		switch ($datos['tipo_fecha'])
		{
			case 'calendario':
				$this->html = "<span class=\"Mtextoimport\">Seleccione la fecha o el período (dd/mm/aaaa)</span><br><label for=\"fecha_inicio\">Desde: </label>
							<input type=\"date\" name=\"fecha_inicio\" min=\"".$datos['periodo']['inicio']."\" max=\"".$datos['periodo']['fin']."\" id=\"fecha_inicio\" value=\"".$datos['periodo']['inicio']."\">
							<label for=\"fecha_fin\">Al: </label><input type=\"date\" name=\"fecha_fin\" min=\"".$datos['periodo']['inicio']."\"
							max=\"".$datos['periodo']['fin']."\" value=\"".$datos['periodo']['fin']."\" id=\"fecha_fin\">";
				break;
			case 'anio':
				$this->html =  "<span class=\"Mtextoimport\">Se tomarán en cuenta 12 meses a partir del periodo inicial que escojas:</span><br>";
				$this->html.= $this->selectAnios(substr($datos['periodo']['inicio'], 0, 4), substr($datos['periodo']['fin'], 0, 4)).'<br>'.$this->selectMeses();
				break;
			case 'mes':
				$this->html = $this->selectMeses();
				break;		
			case 'semana':
				
				break;			
		}
		return $this->html;
	}
	
	public function selectMeses()
	{
		$select="<label for='productos'>Selecciona el mes: </label><select name='mes' id='mes'>";
		$select.="<option value=''>---Selecciona---</option>";
		$select.="<option value='1'>Enero</option>";
		$select.="<option value='2'>Febrero</option>";
		$select.="<option value='3'>Marzo</option>";
		$select.="<option value='4'>Abril</option>";
		$select.="<option value='5'>Mayo</option>";
		$select.="<option value='6'>Junio</option>";
		$select.="<option value='7'>Julio</option>";
		$select.="<option value='8'>Agosto</option>";
		$select.="<option value='9'>Septiembre</option>";
		$select.="<option value='10'>Octubre</option>";
		$select.="<option value='11'>Noviembre</option>";
		$select.="<option value='12'>Diciembre</option>";
		return $select.'</select>';
	}
	
	public function selectAnios($anio_ini, $anio_fin)
	{
		$select="<label for='productos'>Selecciona el año: </label><select name='anio' id='anio'>";
		for ($i=$anio_ini;$i<$anio_fin;$i++)
		{
			$select.="<option value='".$i."'>".$i."</option>";
		}
		return $select.'</select>';
	}

	/**
	 * Las 46 semanas
	 */
	public function selectSemanas()
	{
		$select="<label for='productos'>Selecciona el mes: </label><select name='mes' id='mes'>";
		/*Semana 1: del 01/enero al 08/enero
		Semana 2: del 09/enero al 16/enero
		Semana 3: del 17/enero al 24/enero
		Semana 4: del 25/enero al 01/febrero
		Semana 5: del 02/febrero al 09/febrero
		Semana 6: del 10/febrero al 17/febrero
		Semana 7: del 18/febrero al 25/febrero
		Semana 8: del 26/febrero al 05/marzo
		Semana 9: del 06/marzo al 13/marzo
		Semana 10: del 14/marzo al 21/marzo
		Semana 11: del 22/marzo al 29/marzo
		Semana 12: del 30/marzo al 06/abril
		Semana 13: del 07/abril al 14/abril
		Semana 14: del 15/abril al 22/abril
		Semana 15: del 23/abril al 30/abril
		Semana 16: del 01/mayo al 08/mayo
		Semana 17: del 09/mayo al 16/mayo
		Semana 18: del 17/mayo al 24/mayo
		Semana 19: del 25/mayo al 01/junio
		Semana 20: del 02/junio al 09/junio
		Semana 21: del 10/junio al 17/junio
		Semana 22: del 18/junio al 25/junio
		Semana 23: del 26/junio al 03/julio
		Semana 24: del 04/julio al 11/julio
		Semana 25: del 12/julio al 19/julio
		Semana 26: del 20/julio al 27/julio
		Semana 27: del 28/julio al 04/agosto
		Semana 28: del 05/agosto al 12/agosto
		Semana 29: del 13/agosto al 20/agosto
		Semana 30: del 21/agosto al 28/agosto
		Semana 31: del 29/agosto al 05/septiembre
		Semana 32: del 06/septiembre al 13/septiembre
		Semana 33: del 14/septiembre al 21/septiembre
		Semana 34: del 22/septiembre al 29/septiembre
		Semana 35: del 30/septiembre al 07/octubre
		Semana 36: del 08/octubre al 15/octubre
		Semana 37: del 16/octubre al 23/octubre
		Semana 38: del 24/octubre al 31/octubre
		Semana 39: del 01/noviembre al 08/noviembre
		Semana 40: del 09/noviembre al 16/noviembre
		Semana 41: del 17/noviembre al 24/noviembre
		Semana 42: del 25/noviembre al 02/diciembre
		Semana 43: del 03/diciembre al 10/diciembre
		Semana 44: del 11/diciembre al 18/diciembre
		Semana 45: del 19/diciembre al 26/diciembre
		Semana 46: del 27/diciembre al 31/diciembre
		*/
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
