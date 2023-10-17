<?php
	function getDeciveType(){
		$tablet_browser = 0;
		$mobile_browser = 0;
		$DEVICE_TYPE = "";

		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
		}
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			  $tablet_browser++;
			}
		}
		if ($tablet_browser > 0) {
		   $DEVICE_TYPE = "CELULAR";
		}
		else if ($mobile_browser > 0) {
		   $DEVICE_TYPE = "CELULAR";
		}
		else {
		   $DEVICE_TYPE = "PC";
		}
		return $DEVICE_TYPE;
	}
	
	function moneyFormat($price,$curr = "ARS") {
		$currencies['ARS'] = array(2, ',', '.');          //  Argentine Peso
		return number_format($price, ...$currencies[$curr]);
	}
	
	function addMov($conexion, $tipo, $id_cliente, $id_pedido, $articulo, $cantidad, $stock_act, $importe, $accion, $motivo, $notas, $numero, $user){
		$fecha_mov = date("Y-m-d");
		$hora_mov = date("H:i");
		$result = "";
		$query_insert_mov = "INSERT INTO t_movimientos(estado,tipo,cliente,id_pedido,articulo,cantidad,stock_actual,importe,accion,motivo,notas,numero,user,fecha,hora)
		VALUES('A','$tipo','$id_cliente','$id_pedido','$articulo','$cantidad','$stock_act','$importe','$accion','$motivo','$notas','$numero','$user','$fecha_mov','$hora_mov');";
		$result_insert_mov = mysqli_query($conexion, $query_insert_mov);
		if(!$result_insert_mov){
			$result  = "Error al agregar mov: ". mysqli_error($conexion);
		}
		return $result;
	}
?>