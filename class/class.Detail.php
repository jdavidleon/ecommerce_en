 <?php 

	/**
	* productos Detallados
	*/
	class Detail extends Indexfilters
	{
		private $_id_producto;
		private $_precio_producto;
		private $_producto_detallado = array();
		private $_producto_imagenes = array();
		private $_producto_encapsulado = array();

		// Colores
		private $_coloresDisponibles = array();

		// Descuentos
		private $_dato_descuento = array();

		function __construct($serie = 'null')
		{
	   		// Validacion Producto existente y Variable ID
	        if (isset($serie) AND $serie != 'null') {
                $join = [
                	['INNER','categorias','categorias.id_categoria = productos.id_categoria'],
                	['INNER','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
                	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
                	['LEFT','productos_publicados','productos_publicados.serie = productos.serie'],
                	['LEFT','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto']
                ];
                $where = 'productos.serie = ? AND productos_publicados.estado_publicado = ?';
	            $params = array("ss",$serie,"SI");
                $producto = CRUD::find('productos','*',$where,$params,$join);

	            $pms = $producto[1]->fetch_assoc();
	            $row_products = $producto[1]->num_rows;

	            if ($row_products > 0) {

	                /*-------------------------------*/
	                $id_product = $pms['id_producto'];	
	                $this->_id_producto = $id_product;
	                $this->_precio_producto = $pms['precio'];
	                /*-------------------------------*/

	                // Agregar a vistos recientemente
	                Cookie::agregarEnVistos($id_product);
	                
	            }else{
	                header("Location: ".URL_BASE); 
	            }
	        }
	        if (!isset($id_product)) { 
	            if (isset($_SERVER['HTTP_REFERER'])){
	                $url = $_SERVER['HTTP_REFERER'];
	            }else{
	                $url = URL_BASE;
	            }
	            // header("Location: ".$url); 
	        }else{
	            $titulo_pagina = ucfirst(strtolower($pms['nombre_producto'])); 
	            require DIRECTORIO_ROOT.'includes/header.php';  

	        	$this->_dato_descuento = self::buscarDescuento($pms['id_producto'],$pms['precio']);
	            $this->_producto_detallado = array(
	                'id_producto' =>  $pms['id_producto'],
	                'serie' =>  $pms['serie'],
	                'nombre_producto' =>  $pms['nombre_producto'],
	                'vendidos' => $pms['cantidad_salida'],
	                'ruta_img_frontal' =>  $pms['ruta_img_frontal'],
	                'id_categoria' =>  $pms['id_categoria'],
	                'categoria' =>  $pms['categoria'],
	                'nombre_sub_categoria' => $pms['nombre_sub_categoria'],
	                'precioAntesDescuento' => $pms['precio'],
	                'porcentajeDescuento' => $this->_dato_descuento['porcentaje'],
	                'descuentoPorProducto' => $this->_dato_descuento['valorDescuento'],
	                'precio' => $this->_dato_descuento['precio_final']
		        );	

	            // $sql_imagenes_productos = "SELECT * FROM productos_imagenes WHERE serie = ?";
	            $params = array("s", $serie);

	            $imagenes_productos = CRUD::find('productos_imagenes','*','serie = ?',$params);
	            // $imagenes_productos = Sqlconsult::consultaBd($sql_imagenes_productos,$params);

	            $pos = 0;
	            while ($img_prods = $imagenes_productos[1]->fetch_assoc()) {
	            	$this->_producto_imagenes[$pos] = array(
	            					'id_p_imagenes' => $img_prods['id_p_imagenes'],
	            					'ruta_img_lg' => $img_prods['ruta_img_lg']
	            	);
	            	$pos++;
	            }

	            // Productos
	            $this->_producto_encapsulado = array(
            		'detalles' => $this->_producto_detallado,
            		'imagenes' => $this->_producto_imagenes
            	);
	        }
		}/*Contruct*/


		public function productoEncapsulado()
		{
			return $this->_producto_encapsulado;
		}

		public function colores()
		{
			$rows = 'DISTINCT c.color, c.id_color';	
		    $join = [
		    	['INNER','colores as c','c.id_color = ptc.id_color']
		    ];
		    $where = 'ptc.id_producto = ? AND (ptc.productos_comprados - ptc.productos_vendidos) > ?';
		    $params = array("ii",$this->_id_producto,0);
		    $colorDisponibles = CRUD::find('producto_talla_color as ptc',$rows,$where,$params,$join);

		   	$contar = 0;
		    while ($colores = $colorDisponibles[1]->fetch_assoc()) {
		    	$this->_coloresDisponibles[$contar] = array(
		    			'id_color' => $colores['id_color'],
		    			'color' => $colores['color']
		    		);
		    	$contar++;
		    }

		    return $this->_coloresDisponibles;
		    // Verificacion de la cantidad de productos disponibles
		    //     $sql_disponibilidad = "SELECT * FROM productos_cantidad WHERE id_producto=?";
		    //     $params = array("i",$id_product);
		    //     $disponibilidad = Sqlconsult::consultaBd($sql_disponibilidad,$params);
		    //     $disponible = $disponibilidad[1]->fetch_assoc();
		    //     $total_disp = $disponible['cantidad_entrada'] - $disponible['cantidad_salida'];

		    // // Validacion informacion URL
		    //     $host= $_SERVER["HTTP_HOST"];
		    //     $url= $_SERVER["REQUEST_URI"];
		    //     $permalink = "http://" . $host . $url;
		}

		public static function tallas($id,$color)
		{
			$where = 'producto_talla_color.id_producto = ? AND producto_talla_color.id_color = ? AND (producto_talla_color.cantidad - producto_talla_color.productos_vendidos) > ?';
			$params = array('iii',$id,$color,0);
			$join = [ ['INNER','producto_talla_color','producto_talla_color.id_talla = tallas.id_talla'] ];
			$tallas = CRUD::find('tallas','tallas.talla, tallas.id_talla',$where,$params,$join);

			return $tallas;
		}

		public function contadorPromocion()
		{
		 	// Captura Descuentos
			if ($this->_dato_descuento['porcentaje'] > 0 AND $this->_dato_descuento['valorDescuento'] > 0) {
				$ahora = time(); 
				$promoTiempo = strtotime($this->_dato_descuento['fecha_final']) - $ahora; ?>				
					<!-- <script type="text/javascript">
		                window.onload = function () {
		                    display_c("<?php echo $promoTiempo; ?>");
		                }
		            </script> -->
			<?php 	return array(
						'estado' => 'activa',
						'tiempo_restante' => $promoTiempo
					);
		    }else{
		    	return array(
						'estado' => 'inactiva',
						'tiempo_restante' => null
					);
		    }
		}


		// Productos relcionados por Categoria
		private $_relacionados_categoria = array();
		private $_no_relacionados_categoria = array();

		public function relCategorias($id_cat,$id_producto,$cantidad = 10)
		{
            $params = array("iiis",$id_cat,$id_producto,0,"SI");            
            $where = 'productos.id_categoria = ? AND productos.id_producto <> ? AND (productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) > ? AND productos_publicados.estado_publicado = ? '; 

          	$this->_relacionados_categoria = Products::cargarProductos('*, productos.id_producto',$where,$params,' rand() ',$cantidad);
	     	return $this->_relacionados_categoria;
		}

		public function noRelCategorias($id_cat,$faltantes = 1)
		{
            $params = array("iis",$id_cat,0,"SI");              
            $where = 'productos.id_categoria != ? AND (productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) > ? AND productos_publicados.estado_publicado = ? ';
           	
           	$this->_relacionados_categoria = Products::cargarProductos('*, productos.id_producto',$where,$params,' rand() ',$faltantes);
	     	
	     	return $this->_no_relacionados_categoria;
		}

	}
?>