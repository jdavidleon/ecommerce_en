<?php 
/**
* Orders by client and general
*/
class Orders extends Indexfilters
{

	public static $_dataClient;
	public static $_serial;

	public static function orderList($where='venta_detalle.tm_delete IS NULL',$params=[],$rows='*',$order='venta_detalle.fecha_venta DESC',$limit=null)
	{		
	   $join = [
		['LEFT','usuarios','usuarios.id_usuario = venta_detalle.id_usuario'],
		['LEFT','usuarios_direcciones','usuarios_direcciones.id_direcciones = venta_detalle.id_direccion_envio'],
		['LEFT','departamento','departamento.id_departamento = usuarios_direcciones.id_departamento'],
		['LEFT','ciudades','ciudades.id_ciudad = usuarios_direcciones.id_ciudad'],
		['INNER','estados_pedido','estados_pedido.id_estado = venta_detalle.id_estado'],
		['LEFT','productos_cupones','productos_cupones.id_producto_cupon = venta_detalle.id_producto_cupon']
	   ];
	   	$rows = '*, usuarios.id_usuario';
		$orders = CRUD::find('venta_detalle',$rows,$where,$params,$join,$order,$limit);

		$orderArray = [];

		while ($odr = $orders[1]->fetch_assoc()) {
			$orderArray[] = self::arrayOrders($odr);
		}

		return $orderArray;
	}

	public static function arrayOrders($order)
	{	
		$orderElements = array(
			'id_venta_detalle' => $order['id_venta_detalle'],
			'serial_venta' => $order['serial_venta'],
			'id_usuario' => $order['id_usuario'],
			'nombre' => $order['nombre'],
			'apellido_usuario' => $order['apellido_usuario'],
			'precio_productos' => $order['precio_productos'],
			'precio_envio' => $order['precio_envio'],
			'venta_descuento' => $order['venta_descuento'],
			'clave_cupon' => $order['clave_cupon'],
			'precio_total' => $order['precio_total'],
			'id_estado' => $order['id_estado'],
			'estado_pedido' => $order['estado_pedido'],
			'id_direccion_envio' => $order['id_direccion_envio'],
			'nombre_direccion' => $order['nombre_direccion'],
			'nombre_departamento' => $order['nombre_departamento'],
			'nombre_ciudad' => $order['nombre_ciudad'],
			'direccion' => $order['direccion'],
			'telefono' => $order['telefono'],
			'fecha_venta' => $order['fecha_venta']
		);
		return $orderElements;
	}

	static public function orderDetail($serial)
	{		
		$join = [
			['LEFT','productos','productos.id_producto = ventas.id_producto'],
			['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = ventas.id_producto']
		];
		$params = array('s',$serial);
		$detail = CRUD::find('ventas','*','ventas.serial_venta = ?',$params,$join);

		$ordersData = [];
		while ($det = $detail[1]->fetch_assoc()) {
			
			$ordersData[] = array(
				'id_venta' => $det['id_venta'],
				'serial_venta' => $det['serial_venta'],
				'id_producto' => $det['id_producto'],
				'serie' => $det['serie'],
				'nombre_producto' => $det['nombre_producto'],
				'ruta_img_lg' => $det['ruta_img_lg'],
				'ruta_img_sm' => $det['ruta_img_sm'],
				'ruta_img_tn' => $det['ruta_img_tn'],
				'cantidad' => $det['cantidad'],
				'precio_unitario' => $det['precio_unitario'],
				'descuento' => $det['descuento'],
				'precio_total_producto' => $det['precio_total_producto']
			);
		}

		self::$_dataClient = Secure::decodeArray(self::clientOrder($serial));
		return $ordersData;
	}

	static public function clientOrder($serial)
	{	
		$where = 'venta_detalle.serial_venta = ?';
		$params = ['s',$serial];
		$join = [
			['INNER','usuarios','usuarios.id_usuario = venta_detalle.id_usuario'],
			['LEFT','usuarios_direcciones','usuarios_direcciones.id_direcciones = venta_detalle.id_direccion_envio'],
			['LEFT','departamento','departamento.id_departamento = usuarios_direcciones.id_departamento'],
			['LEFT','ciudades','ciudades.id_ciudad = usuarios_direcciones.id_ciudad'],
		];
		$cliente = CRUD::find('venta_detalle','*',$where,$params,$join);
		return $cliente[1]->fetch_assoc();
	}

	static public function ordersClient($usuarioID)
	{
		$where = 'venta_detalle.id_usuario = ?';
		$params = ['i',$usuarioID];
		$join = [
			['INNER','usuarios','usuarios.id_usuario = venta_detalle.id_usuario'],
			['LEFT','usuarios_direcciones','usuarios_direcciones.id_direcciones = venta_detalle.id_direccion_envio'],
			['LEFT','departamento','departamento.id_departamento = usuarios_direcciones.id_departamento'],
			['LEFT','ciudades','ciudades.id_ciudad = usuarios_direcciones.id_ciudad'],
			['LEFT','estados_pedido','estados_pedido.id_estado = venta_detalle.id_estado'],
			['LEFT','productos_cupones','productos_cupones.id_producto_cupon = venta_detalle.id_producto_cupon']
		];
		$ordenes = CRUD::all('venta_detalle','*, venta_detalle.id_usuario',$where,$params,$join);
		$pedidos = [];
		foreach ($ordenes as $orden) {
			$pedidos[] = self::arrayOrders($orden);
		}

		return $pedidos;
	}

	static public function newOrder($data)
	{	
		/*serial*/
		$fecha_unix = time();
		$serial = $fecha_unix.'-'.$data['id_usuario'];
		self::$_serial = $serial;
		$lang = $data['lang'];
		/*serial*/

		/*Validar Serial*/
			$buscarSerial = CRUD::numRows('venta_detalle','*','serial_venta = ?',['s',$serial]);
			if ($buscarSerial > 0) {
				$msn = 'Ha ocurrido un error al procesar la solicitud. Por favor intentalo Nuevamente.';
				header('Location: '.URL_BASE.'checkout/error/'.$msn);	
				return false;
			}
		/*Validar Serial*/

		
		/*Disponibilidad*/
			if (!self::disponibilidad()) {
				$msn = 'La disponibilidad de los productos de tu cesta ha cambiado. Revisala nuevamente.';
				header('Location: '.URL_BASE.'checkout/error/'.$msn);	
				return false;
			}
		/*Disponibilidad*/

		/*Cargar productos del pedido*/
			$bolsaCompras = new Checkout;
			$bolsa = $bolsaCompras->productosBolsa;
			$precio_total = 0;
			foreach ($bolsa as $prod) {
				$precio = CRUD::all('productos','precio','id_producto = ?',['i',$prod['id_producto']]);
				$total_producto = $precio[0]['precio'] * $prod['cantidad_bolsa'];
				$precio_total = $precio_total + $total_producto;
				/*Item List*/
    			$items = Products::itemsProducts( $prod['id_producto'] );
    			$listItems = '';
    			foreach ($items as $item) {
    				$listItems .= $item['id_item'].'-';
    			}
    			$listItems = substr($listItems,0,-1);
				/*Item List*/
				$dat = [
					'serial_venta' => $serial,
					'id_producto' => $prod['id_producto'],
					'cantidad' => $prod['cantidad_bolsa'],
					'item_list' => $listItems,
					'precio_unitario' => $precio[0]['precio'],
					'descuento' => 0,
					'precio_total_producto' => $total_producto
				];
				$unique = [
					'conditional' => 'serial_venta = ? AND id_producto = ?',
					'params' => ['si',$serial,$prod['id_producto']]
				];
				$ventaNueva = CRUD::insert('ventas',$dat,$unique);
				$set = [ 'serial_venta' => $serial ];
				$where = 'id_bolsa_compras = ?';
				$params = ['i',$prod['id_bolsa_compras']];
				$mensaje = CRUD::update('venta_personalizar',$set,$where,$params);

				if ($ventaNueva[0]->affected_rows < 1) {
					CRUD::delete('ventas','serial_venta = ?',['s',$serial]);

					$msn = 'Ha ocurrido un error al procesar la solicitud. Por favor intentalo Nuevamente.';
					header('Location: '.URL_BASE.'checkout/error/'.$msn);		
					return false;
				}
			}
		/*Cargar productos del pedido*/

		//*Buscar Cupon*/



		//*Buscar Cupon*/


		/*Cargar venta detalle*/
			$dat = [
					'serial_venta' => $serial,
					'id_usuario' => $_SESSION['id_usuario'],
					'precio_productos' => $precio_total,
					'precio_envio' => 0,
					'venta_descuento' => 0,
					'id_producto_cupon' => $data['id_producto_cupon'],
					'valor_cupon' => $data['cupon'],
					'precio_total' => $precio_total - $data['cupon'],
					'fecha_venta' => date("Y-m-d H:i:s"),
					'id_estado' => 1,
					'id_direccion_envio' => $data['id_direccion'],
					'fecha_entrega' => $data['fecha_entrega']
				];
				$unique = [
					'conditional' => 'serial_venta = ? AND id_usuario = ?',
					'params' => ['si',$serial,$_SESSION['id_usuario']]
				];
			$ingresar_venta = CRUD::insert('venta_detalle',$dat,$unique);

			if ($ingresar_venta[0]->affected_rows === 1) {

				/*Actualizar cantidad_salida*/
				$precio_total = 0;
				$error = 0;

				foreach ($bolsa as $prod) {

					$actual = CRUD::all('productos_cantidad','id_cantidades, cantidad_salida','id_producto = ?',['i',$prod['id_producto']]);

					$nueva = $prod['cantidad_bolsa'] + $actual[0]['cantidad_salida'];

					$set = [
						'cantidad_salida' => $nueva
					];
					$where = 'id_cantidades = ?';
					$params = ['i',$actual[0]['id_cantidades']];
					$actualizar = CRUD::update('productos_cantidad',$set,$where,$params);

					
					if ($actualizar[0]->affected_rows !== 1) {
						$error++;
					}
				}

				if ($error === 0) {
					CRUD::falseDelete('bolsa_compras','id_usuario = ?',['i',$_SESSION['id_usuario']]);
					$whereCupon = 'id_usuario_cupon = ?';
					$dataCupon = ['i',$data['id_usuario_cupon']];
					CRUD::falseDelete('usuario_cupon',$whereCupon,$dataCupon);

					$where = 'id_producto_cupon = ?';
					$params = ['i',$data['id_producto_cupon']];
					$numUsados = CRUD::all('productos_cupones','cupones_usados',$where,$params);
					if (count($numUsados) === 1) {
						$cupones_usados = $numUsados[0]['cupones_usados'] + 1;
						$set = [
							'cupones_usados' => (int) $cupones_usados,
						];
						CRUD::update('productos_cupones',$set,$where,$params);
						CRUD::update('usuario_cupon',['tm_used' => date("Y-m-d H:i:s")],$whereCupon,$dataCupon);
					}

				}else{
					$restaurarCantidades = CRUD::all('ventas','id_producto, cantidad','serial = ?',['s',$serial]);

					foreach ($restaurarCantidades as $prd) {
						$actual = CRUD::all('productos_cantidad','id_cantidades, cantidad_salida','id_producto = ?',['i',$prd['id_producto']]);
						$nueva = $actual[0]['cantidad_salida'] - $prd['cantidad'] ;
						$set = [
							'cantidad_salida' => $nueva
						];
						$where = 'id_cantidades = ?';
						$params = ['i',$actual[0]['id_cantidades']];
						$insert = CRUD::update('productos_cantidad',$set,$where,$params);
					}

					$set = [
						'id_estado' => 6
					];
					$where = 'serial_venta = ?';
					$params = ['s',$serial];
					CRUD::update('venta_detalle',$set,$where,$params);

					$msn = 'Ha ocurrido un error al procesar la solicitud. Por favor intentalo Nuevamente.';
					header('Location: '.URL_BASE.'checkout/error/'.$msn);		
					return false;
				}
				/*Actualizar cantidad_salida*/				
			}else{
				CRUD::delete('ventas','serial_venta = ?',['s',$serial]);
				$msn = 'Ha ocurrido un error con la solicitud.';
				header('Location: '.URL_BASE.'checkout/error/'.$msn);

				return false;
			}
		/*Cargar venta detalle*/
		
		return true;
	}

	static public function disponibilidad()
	{			
		$where = 'id_usuario = ? AND tm_delete IS NULL';
		$bolsa = CRUD::all('bolsa_compras','*',$where,['i',$_SESSION['id_usuario']]);	

		if (count($bolsa) === 0) {
			return false;
		}
		foreach ($bolsa as $producto) {
			$cantidad = $producto['cantidad_bolsa'];
			$rows = '(cantidad_entrada - cantidad_salida) as disponible';
			$where = 'id_producto = ?';
			$params = ['i',$producto['id_producto']];
			$buscar = CRUD::all('productos_cantidad',$rows,$where,$params);
			if ($cantidad > $buscar[0]['disponible']) {
				return false;	
			}
		}
		return true;
	}

}	

	