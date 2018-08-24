<?php 
	/**
	* Gestion de datos para facturación 
	*/
	class Checkout{

		public $cantidad_bolsa = 0;
		public $cantidad_bolsa_agotados = 0;
		private $_idUser;
		private $_consultaBolsa = [];
		private $_consultaBolsaAgotados = [];

		// Calculo precios carrito Compras
		public $_totalPagar = 0;
	    public $_totalDescuento = 0;
	    public $_totalAntesDeDescuento = 0;
	    public $precioFinal = 0;
	    public $costoEnvio = 0;
	    public $cupon = 0;

	    // Resume
	    public $totalDescuento = 0;
	    public $totalAntesDeDescuento = 0;
	    public $totalProductos = 0;
	    public $cupon_descuento = '';
	    
	    // productos Bolsa
	    public $productosBolsa = [];
	    public $productosBolsaAgotados = [];

		function __construct(){	
			if (isset($_SESSION['id_usuario'])) {
				$this->_idUser = $_SESSION['id_usuario'];
				/*Validacion Bolsa*/
				$rows = '*, productos.id_producto, (productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) as disponibles, productos.id_categoria';
		        $where = 'bolsa_compras.id_usuario = ? AND bolsa_compras.tm_delete IS NULL AND productos_publicados.estado_publicado = ?';
		        $params = array("is",$this->_idUser,'SI');	
		        $join = [
		        	['INNER','productos','productos.id_producto = bolsa_compras.id_producto'],
		        	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
		            ['INNER','categorias','categorias.id_categoria = productos.id_categoria'],
		            ['LEFT','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
		        	['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
		        	['LEFT','productos_publicados','productos_publicados.serie = productos.serie'],
		        	['LEFT','productos_agotados','productos_agotados.id_producto = productos.id_producto'],
		        ];
		        $consulta_bolsa = CRUD::find('bolsa_compras',$rows,$where,$params,$join,'productos.serie');        

		        while ($consultaB = $consulta_bolsa[1]->fetch_assoc() ) {
		        	// if ($consultaB['disponibles'] < 1) {
		        	// 	$consultaB['disponibles'] = 1;
		        	// }
		        	if ($consultaB['disponibles'] < $consultaB['cantidad_bolsa']) {
		        		$set = ['cantidad_bolsa' => $consultaB['disponibles'] ];
		        		$where = 'id_bolsa_compras = ?';
		        		$params = ['i',$consultaB['id_bolsa_compras']];
		        		$actualizar = CRUD::update('bolsa_compras',$set,$where,$params);
		        		$cantidad_bolsa = $consultaB['disponibles'];
		        	}else{
		        		$cantidad_bolsa = $consultaB['cantidad_bolsa'];
		        	}
		        	if ($consultaB['disponibles'] > 0 AND $consultaB['estado_agotado'] <> 'SI') {
		        		$this->productosBolsa[] = self::arrayProductosBolsa($consultaB,$consultaB['id_bolsa_compras'],$cantidad_bolsa);
		        		$this->cantidad_bolsa++;
		        	}elseif ($consultaB['disponibles'] == 0 || $consultaB['estado_agotado'] == 'SI') {
		        		$this->productosBolsaAgotados[] = self::arrayProductosBolsa($consultaB,$consultaB['id_bolsa_compras'],0);
		        		$this->cantidad_bolsa_agotados++;
		        	}		        	
		        }
			}elseif (isset($_COOKIE['bolsa'])) {
		         $aCarrito = Cookie::readCookie('bolsa');

		         foreach ($aCarrito as $value) {
		         	//Productos Disponibles
		         	$rows = '*, productos.id_producto, (productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) as disponibles, productos.id_categoria';
			        $where = 'productos.id_producto = ?';
			        $params = ['i',$value['id_producto']];	
			        $join = [
			        	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
			            ['INNER','categorias','categorias.id_categoria = productos.id_categoria'],
			            ['LEFT','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
			        	['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
		        		['LEFT','productos_publicados','productos_publicados.serie = productos.serie'],
		        		['LEFT','productos_agotados','productos_agotados.id_producto = productos.id_producto'],
			        ];
		         	$consulta_bolsa = CRUD::find('productos',$rows,$where,$params,$join,'productos.serie');
		         	
		         	while ($consultaB = $consulta_bolsa[1]->fetch_assoc() ) {
			        	if ($consultaB['disponibles'] < $value['cantidad_bolsa']) {
			        		$key = [
			        			'key' => 'id_producto',
			        			'value' => $value['id_producto']
			        		];
			        		$data = [
			        			'update' => 'cantidad_bolsa',
			        			'data' => $consultaB['disponibles']
			        		];
			        		$actualizar = Cookie::updateCookie('bolsa',$key,$data);

			        		$cantidad_bolsa = $consultaB['disponibles'];

			        	}else{
			        		$cantidad_bolsa = $value['cantidad_bolsa'];
			        	}	        	

		        		$consultaB['id_direcciones'] = 0;

			        	if ($consultaB['disponibles'] > 0) {
			        		$this->productosBolsa[] = self::arrayProductosBolsa($consultaB,'null',$cantidad_bolsa);
			        		$this->cantidad_bolsa++;
			        	}elseif ($consultaB['disponibles'] == 0) {
			        		$this->productosBolsaAgotados[] = self::arrayProductosBolsa($consultaB,null,0);
			        		$this->cantidad_bolsa_agotados++;
			        	}		        	
			        }
		        }

		        $this->cantidad_bolsa = count($this->productosBolsa);
		    }else {
		        $this->cantidad_bolsa = 0;
		    }   
		}/*Constructor*/

		public static function arrayProductosBolsa($pms,$bolsaID = 'null',$cantidadBolsa=0)
		{
			$datoDescuento = Indexfilters::buscarDescuento($pms['id_producto'],$pms['precio']);

          	$arrayProductos = array(
          		'id_bolsa_compras' => $bolsaID,
                'id_producto' =>  $pms['id_producto'],
                'cantidad_bolsa' =>  $cantidadBolsa,
                'serie' =>  $pms['serie'],
                'nombre_producto' =>  $pms['nombre_producto'],
                'id_categoria' => $pms['id_categoria'],
                'categoria' => $pms['categoria'],
                'nombre_sub_categoria' => $pms['nombre_sub_categoria'],
                'cantidad_entrada' => $pms['cantidad_entrada'],
                'cantidad_salida' => $pms['cantidad_salida'],
                'estado_agotado' => $pms['estado_agotado'],
                'disponibles' => $pms['disponibles'],
                'ruta_img_lg' =>  $pms['ruta_img_lg'],
                'ruta_img_sm' =>  $pms['ruta_img_sm'],
                'ruta_img_tn' =>  $pms['ruta_img_tn'],
                'precioAntesDescuento' => $pms['precio'],
                'precioAntesDescuentoTotal' => $pms['precio']*$cantidadBolsa,
                'porcentajeDescuento' => $datoDescuento['porcentaje'],
                'descuentoPorUnidad' => $datoDescuento['valorDescuento'],
                'descuentoPorProducto' => $datoDescuento['valorDescuento'] * $cantidadBolsa,
                'precio' => $datoDescuento['precio_final'],
                'precio_total' => $datoDescuento['precio_final']*$cantidadBolsa,
          	);
          	return $arrayProductos;
		}

	   		
   		public function resumenCarrito()
   		{	
   			foreach ($this->productosBolsa as $producto) {
   				// Descuentos
	            $datoDescuento = Indexfilters::buscarDescuento($producto['id_producto'],$producto['precio'] );  

	            $this->totalDescuento += $producto['descuentoPorProducto'];
	            $this->totalAntesDeDescuento += $producto['precioAntesDescuento'] * $producto['cantidad_bolsa'];
	            $this->totalProductos += $producto['precio_total'];
	   		}

	   		$newCoupon = new Coupon;
			$userCoupon = $newCoupon->findUserCoupon();
			$this->cupon_descuento = $userCoupon;

			if ($userCoupon !== false) {
				$this->cupon = $newCoupon->calculateCoupon($this->cupon_descuento);
			}
		
			$this->costoEnvio = self::shippingCost();

            /*PRECIO FINAL*/
            $this->precioFinal = $this->totalAntesDeDescuento + $this->costoEnvio - $this->totalDescuento - $this->cupon;
            /*PRECIO FINAL*/	
   		}

   		static public function shippingCost()
   		{	
   			if ($session) {
				$direcciones = User::address($_SESSION['id_usuario']);
   			}elseif (Cookie::readCookie('addr_us_shp')) {
				$direcciones = Cookie::readCookie('addr_us_shp');
			}else{
				return 0;
			}
   		}


   		static public function disponibilidad($bolsaID)
   		{	
   			$join = [
   				['INNER','productos_cantidad','productos_cantidad.id_producto = bolsa_compras.id_producto']
   			];
   			$where = 'bolsa_compras.id_bolsa_compras = ?';
   			$params = ['i',$bolsaID];
   			$rows = '(productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) as disponibles, cantidad_bolsa';
   			$buscar = CRUD::all('bolsa_compras',$rows,$where,$params,$join);

   			return $buscar;
   		}

   		// Used to migrate products from Cookies to DB of a Logged in User
   		public function migrarProductos()
   		{	
   			if (isset($_COOKIE['bolsa']) AND isset($_SESSION['id_usuario'])) {
   				$bolsa = Cookie::readCookie('bolsa');
   				foreach ($bolsa as $producto) {
	   				$dataProducto = [
	   					'id_producto' => $producto['id_producto']
	   				];
	   				self::agregarCarrito($dataProducto,$producto['cantidad']);
	   			}
	   			Cookie::deleteCookie('bolsa');
   			} 		
   		}

   		public static function agregarCarrito($data)
   		{	
   			/*Validar Cantidad disponible*/
   			$rows = '(cantidad_entrada - cantidad_salida) as disponibles';
   			$where = 'id_producto = ?';
   			$params = ['i',$data['id_producto']];
   			$disponibilidad = CRUD::all('productos_cantidad',$rows,$where,$params);

   			if (count($disponibilidad) < 1) {
   				echo "No existe el producto";
   				return false;
   			}

   			$disp = $disponibilidad[0]['disponibles'];

   			if ($disp === 0) {
   				// echo 'No hay suficientes unidades del producto que solicitaste';
				return false;
   			}elseif ($disp < $data['cantidad_bolsa'] ) {
   				$data['cantidad_bolsa'] = $disp;
   			}
   			/*Validar Cantidad disponible*/


   			if (isset($_SESSION['id_usuario'])) {	
				$data['id_usuario'] = $_SESSION['id_usuario'];	
				$data = [
					'id_usuario' => $data['id_usuario'], 
					'id_producto' => $data['id_producto'],
					'cantidad_bolsa' => $data['cantidad_bolsa']
				];
				$unique = [
					'conditional' => 'id_usuario = ? AND id_producto = ? AND tm_delete IS NULL',
					'params' => ['ii',$data['id_usuario'], $data['id_producto']]
				];

				if (CRUD::insert('bolsa_compras',$data,$unique) === false) {
					return false;
				}else{					
					/*Copiar en cookies la bolsa*/
						Cookie::deleteCookie('bolsa');				
						$carrito = new Checkout;
						$productos_bolsa = $carrito->productosBolsa;
						$contar = 0;
						$bolsa = [];
						foreach ($productos_bolsa as $p) {
							$bolsa[$contar]['id_producto'] = (int) $p['id_producto'];
							$bolsa[$contar]['cantidad_bolsa'] = (int) $p['cantidad_bolsa'];
							$contar++;
						}
						Cookie::createCookie('bolsa',$bolsa);
					/*#Copiar en cookies la bolsa*/
					return true;
				}

			}elseif (isset($_COOKIE['bolsa'])) {
				$data = [ 
					[
						'id_producto' => (int) $data['id_producto'],
						'cantidad_bolsa' => (int) $data['cantidad_bolsa'],
					]
				];

				$insertar = Cookie::insertInCookie('bolsa',$data,258000,'id_producto');

				if ($insertar == false) {
					// echo 'BAG_ERROR_EXIST';
					return false;
				}else{
					// echo 'success_product_add';
					return false;					
				}
			}else{
				$bolsa[0]['id_producto'] = (int) $data['id_producto'];
				$bolsa[0]['cantidad_bolsa'] = (int) $data['cantidad_bolsa'];

				if (Cookie::createCookie('bolsa',$bolsa)) {
					// echo 'success_product_add';
					return false;
				}
				return false;
			}	
	   	}
	}

		


 ?>