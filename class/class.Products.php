<?php 

	/**
	* Proceso de categorias
	*/
	class Products extends Indexfilters
	{	
		// Categoria
		static private $_totalImpresosCategoria;
		static public $_totalEnCategoria;
		static private $_productos_categoria = array();

		// Sub-categoria
		static private $_totalImpresosSubCategoria;		
		static public $_totalEnSubCategoria;
		static private $_productos_sub_categoria = array();

		// Search
		private $_totalImpresosSearch;		
		private $_totalEnSearch;
		private $_productos_search = array();


		function __construct($cat = "null")
		{	
			if ($cat != "null") {
				$params = array('s',Sqlconsult::escape(ucwords($cat)));

				$verificar_en_categorias = CRUD::find('categorias','*','categoria = ?',$params);

				if ($verificar_en_categorias[1]->num_rows == 0) {
					$verificar_en_subcategorias = CRUD::find('categorias_sub','*','nombre_sub_categoria = ?',$params);					
					if ($verificar_en_subcategorias[1]->num_rows == 0) {
						 echo '<script type="text/javascript">
					        window.location.assign("'.URL_BASE.'");
					        </script>';
					        exit();
					}
				}
			}
		}


		public static function cargarProductos($rows='*, productos.id_producto, productos.id_categoria',$where=null,$params=[],$order=null,$limit=null)
		{
	       $join = [
            	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
            	['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
            	['LEFT','categorias','categorias.id_categoria = productos.id_categoria'],
            	['LEFT','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
            	['LEFT','productos_publicados','productos_publicados.serie = productos.serie'],
            	['LEFT','productos_agotados','productos_agotados.id_producto = productos.id_producto'],
            ];          
            $producto = CRUD::find('productos',$rows,$where,$params,$join,$order,$limit);

            $productos=[];
            while ($pms = $producto[1]->fetch_assoc()) {
	          	$productos[] = Products::arrayProductos($pms);
	    	}  	    	
	    	return $productos;
		}

		public static function arrayProductos($pms)
		{
			$datoDescuento = parent::buscarDescuento($pms['id_producto'],$pms['precio']);

          	$variable = array(
                'id_producto' =>  $pms['id_producto'],
                'serie' =>  $pms['serie'],
                'nombre_producto' =>  $pms['nombre_producto'],
                'estado_publicado' =>  $pms['estado_publicado'],
                'estado_agotado' =>  $pms['estado_agotado'],
                'descripcion' =>  $pms['descripcion'],
                'id_categoria' =>  $pms['id_categoria'],
                'categoria' => $pms['categoria'],
                'id_sub_categoria' => $pms['id_sub_categoria'],
                'sub-categoria' => $pms['nombre_sub_categoria'],
                'cantidad_entrada' => $pms['cantidad_entrada'],
                'cantidad_salida' => $pms['cantidad_salida'],
                'id_pip' =>  $pms['id_pip'],
                'ruta_img_lg' =>  $pms['ruta_img_lg'],
                'ruta_img_sm' =>  $pms['ruta_img_sm'],
                'ruta_img_tn' =>  $pms['ruta_img_tn'],
                'precioAntesDescuento' => $pms['precio'],
                'porcentajeDescuento' => $datoDescuento['porcentaje'],
                'descuentoPorProducto' => $datoDescuento['valorDescuento'],
                'precio' => $datoDescuento['precio_final'] 
          	);
          	return $variable;
		}

		static public function itemsProducts($productoID,$lang='es')
		{	
			$where = 'productos_con_items.id_producto = ? AND productos_con_items.tm_delete IS NULL';
			$join = [
				['INNER','productos_items','productos_con_items.id_item = productos_items.id_item'],
				['INNER','productos_items_tipos','productos_items_tipos.id_tipo_item = productos_items.id_tipo_item'],
			];
			$order = 'productos_items.item_'.$lang;
			$lista = CRUD::all('productos_con_items','*',$where,['i',$productoID],$join,$order);
				
			usort($lista, ['Products',"orderItemsArray"]);

			return $lista;
		}

		static private function orderItemsArray($a,$b)
		{
			if ($a['tipo_item'] == 'CONTENEDOR') return -1;
		    if ($b['tipo_item'] == 'CONTENEDOR') return 1;

		    if ($a['tipo_item'] == 'ADORNO') return -1;
		    if ($b['tipo_item'] == 'ADORNO') return 1;

		    if ($a['tipo_item'] == 'COMIDA') return -1;
		    if ($b['tipo_item'] == 'COMIDA') return 1;

		    if ($a['tipo_item'] == 'BEBIDA') return -1;
		    if ($b['tipo_item'] == 'BEBIDA') return 1;

		    if ($a['tipo_item'] == 'COMPLEMENTO') return -1;
		    if ($b['tipo_item'] == 'COMPLEMENTO') return 1;
		}


		static public function find($productoID)
		{	
			$join = [
            	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
            	['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
            	['LEFT','categorias','categorias.id_categoria = productos.id_categoria'],
            	['LEFT','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
            	['LEFT','productos_publicados','productos_publicados.serie = productos.serie'],
            	['LEFT','productos_agotados','productos_agotados.id_producto = productos.id_producto'],
            ];  
            $rows = '*, productos.id_producto, categorias.id_categoria, categorias_sub.id_sub_categoria, productos.descripcion';
            $where = 'productos.id_producto = ?';
            $params = ['s',$productoID];
            $producto = CRUD::all('productos',$rows,$where,$params,$join);

            if (count($producto) > 0) {
	    		return Secure::decodeArray(Products::arrayProductos($producto[0]));
            }else{
            	return [];
            }
		}

		static public function imgProducts($serie)
		{
			$where = 'serie = ? AND tm_delete IS NULL';
			$params = ['s',$serie];
			$buscar =  CRUD::all('productos_imagenes','*',$where,$params);

			$images = [];
			foreach ($buscar as $img) {
				$images[] = (object) $img;
			}

			return  $images;
		}

		static public function findDetails($serie)
		{
			$where = 'serie = ?';
			$params = ['s',$serie];
			$buscar = CRUD::all('productos_items','*',$where,$params);
			return $buscar;
		}

		static public function consultaPorCategorias($categoriaID,$order = null,$limit=null)
		{	
	        $params = ['is', $categoriaID, Sqlconsult::escape("SI")];
	        $where = 'categorias.id_categoria = ? AND productos_publicados.estado_publicado = ? AND productos.tm_delete IS NULL';
	        $join = [
            	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
            	['LEFT','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
            	['LEFT','productos_descuento','productos_descuento.id_producto = productos.id_producto'],
            	['INNER','categorias','categorias.id_categoria = productos.id_categoria'],
            	['LEFT','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
            	['LEFT','productos_publicados','productos_publicados.serie = productos.serie']
            ];    
	        self::$_totalEnCategoria = CRUD::numRows('productos','productos.id_producto',$where,$params,$join);
	        
		    $params = ['is', $categoriaID, Sqlconsult::escape("SI")];
	        $where = 'categorias.id_categoria = ? AND productos_publicados.estado_publicado = ? AND productos.tm_delete IS NULL';
	        if ($order = null) {
	        	$order = '(productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) DESC';
	        }

	        self::$_productos_categoria = self::cargarProductos('*, productos.id_producto, productos.id_categoria',$where,$params,$order,$limit);
	        self::$_totalImpresosCategoria = count(self::$_productos_categoria);

		    return self::$_productos_categoria;
		}

		public function consultaPorSubCategorias($sub_categoria)
		{			
		    /*Total Productos*/
	        $params = array('ss', $sub_categoria, Sqlconsult::escape("SI"));
	        $where = 'categorias_sub.nombre_sub_categoria = ? AND productos_publicados.estado_publicado = ?';
	        $productos_total = $this->cargarProductos('*, productos.id_producto, categorias.categoria',$where,$params);
	         $join = [
            	['INNER','productos_cantidad','productos_cantidad.id_producto = productos.id_producto'],
            	['INNER','productos_imagenes_principales','productos_imagenes_principales.id_producto = productos.id_producto'],
            	['LEFT','productos_descuento','productos_descuento.id_producto = productos.id_producto'],
            	['INNER','categorias','categorias.id_categoria = productos.id_categoria'],
            	['INNER','categorias_sub','categorias_sub.id_sub_categoria = productos.id_sub_categoria'],
            	['LEFT','productos_publicados','productos_publicados.serie = productos.serie']
            ];  
	        $this->_totalEnSubCategoria = CRUD::numRows('productos','productos.id_producto',$where,$params,$join);

		   /*Busqueda de productos por sub-categoria*/
	        $params = array('ss', $sub_categoria, Sqlconsult::escape("SI"));
	        $where = 'categorias_sub.nombre_sub_categoria = ? AND productos_publicados.estado_publicado = ?';
	        $order = '(productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) DESC';

	        $this->_productos_sub_categoria = $this->cargarProductos('*, productos.id_producto',$where,$params,$order,12);
	        $this->_totalImpresosSubCategoria = count($this->_productos_sub_categoria);
	        
		    return $this->_productos_sub_categoria;
		}

		public function consultaSearch($search)
		{	
			/*Total Productos*/
	        $params = array('ss', "%$search%", 'SI');
	        $where = 'productos.nombre_producto LIKE ? AND productos_publicados.estado_publicado = ?';
	        $productos_total = $this->cargarProductos('productos.id_producto',$where,$params);
	        $this->_totalEnSearch = count($productos_total);

			/*Busqueda de productos personalizada*/	        	   
	        $params = array('ss', '%'.$search.'%', 'SI');
	        $where = 'productos.nombre_producto LIKE ? AND productos_publicados.estado_publicado = ?';
	        $order = '(productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) DESC';

	        $this->_productos_search = $this->cargarProductos('*',$where,$params,$order,12);
	        $this->_totalImpresosSearch = count($this->_productos_search);

		    return $this->_productos_search;
		}

		/*Cargar mas productos*/
		private $_mas_productos = [];

		public function cargarMas()
		{
			
		}
	}



 ?>