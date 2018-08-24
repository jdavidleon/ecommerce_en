<?php 

	/**
	* Filtros para Index.php
	*/
	class Indexfilters
	{
		
	    // Variables de consulta personalzadas
	    private $_mas_vendidos = [];
	    private $_mas_stock = array();
	    private $_mas_nuevos = array();
	    private $_where = 'productos_publicados.estado_publicado = ?';
	    private $_params = ['s','SI'];


	    //Seleccion personalizada de productos
	    public function productosMasVendidos($cantidad = 4)
	    {		
		    $order = 'productos_cantidad.cantidad_salida DESC';
		    $this->_mas_vendidos = Products::cargarProductos('*, productos.id_producto',$this->_where,$this->_params,$order,$cantidad);
		    
		    return $this->_mas_vendidos;
	    }

	    public function productosMayorStock($cantidad = 5)
	    {
	    	$order = '(productos_cantidad.cantidad_entrada - productos_cantidad.cantidad_salida) DESC';
		    $this->_mas_stock = Products::cargarProductos('*, productos.id_producto',$this->_where,$this->_params,$order,$cantidad);
	      	return $this->_mas_stock;
	    }

	    public function productosNuevos($cantidad = 5)
	    {		
	    	$order = 'productos.fecha_entrada DESC';
		    $this->_mas_nuevos = Products::cargarProductos('*, productos.id_producto',$this->_where,$this->_params,$order,$cantidad);
	      	return $this->_mas_nuevos;	      
	    }

	    static public function buscarDescuento($idProducto,$precio)
	    {	
            $where = 'id_producto = ? AND fecha_inicial < NOW() AND fecha_limite > NOW() AND tm_delete IS NULL';
	        $params = ['i', $idProducto];
            $descuento = CRUD::all('productos_descuento','*',$where,$params);
	        if (count($descuento) > 0) {
                $desc = $descuento[0];
	            $porcentaje = $desc['porcentaje'];
	            $valorDescuento = ($precio*$porcentaje)/100;
	            $precioFinal = $precio - $valorDescuento;
	            $fecha_inicial = $desc['fecha_inicial'];
	            $fecha_final = $desc['fecha_limite'];
	        }else{
	            $porcentaje = 0;
	            $valorDescuento = 0;
	            $precioFinal = $precio;
	            $fecha_inicial = null;
	            $fecha_final = null;            
	        }

	        return array(
               'porcentaje' => $porcentaje,
               'valorDescuento' => $valorDescuento,
               'precio_final' => $precioFinal,
               'fecha_inicial' => $fecha_inicial,
               'fecha_final' => $fecha_final
	        );  
	    }

        static public function activeWP($productoID)
        {
            $data = [];
            $wl = 0;
            if (isset($_SESSION['id_usuario'])) {
                $where = 'id_usuario = ? AND tm_delete IS NULL';
                $wl = CRUD::numRows('bolsa_deseos','*',$where,['i',$_SESSION['id_usuario']]);
            } elseif (isset($_COOKIE['wishlist'])) {
                $cwl = Cookie::readCookie('wishlist');
                foreach ($cwl as $p) {
                    if ($p['id_producto'] == $productoID) {
                        $wl = $wl + 1;
                    }
                }
            }       
            if ($wl > 0) {
                $data = [
                    'classH' => 'fa-heart checked',
                    'function' => 'removeWishlist('.$productoID.')'
                ];
            }else{                
                $data = [
                    'classH' => 'fa-heart-o',
                    'function' => 'addWishlist('.$productoID.')'
                ];
            }
            return $data;
        }

	    static public function imprimirProductoStatic($arrayProductos)
	    { ?>
	    	<div class="container">
                <div class="row" style="background-color: transparent;">
                    <?php 
                        foreach ($arrayProductos as $producto): 
                            $wl = self::activeWP($producto['id_producto']);
                    ?>

                        <div class="col-md-3" style="padding: 0 35px">
                            <div class="thumbnail" style="background-color: transparent; border: none; position: relative; box-shadow: 0px 2px 6px 1px grey; padding: 0;">
                                <img src="<?php echo URL_BASE.'imgproductos/'.$producto['serie'].'/'.$producto['ruta_img_frontal']; ?>" alt="<?php echo $producto['nombre_producto']; ?>" style="width: 100%; height: 270px; ">
                                
                                <div class="caption" style="background-color: #fcfcf4; padding: 9px 18px 20px 18px; border: 1px solid #f5f5dc; border: 0;">
                                	<a style="cursor: pointer;" >
                                		<i class="fa <?php echo $wl['classH']; ?> pull-right heartWL" onclick="<?php echo $wl['function']; ?>" style="margin: 12px 6px; color: grey;">
                                        </i>
                                    </a> 
                                    <h5 style="margin-bottom: 2px; margin-top: 4px;"><a style=" color: black;" href="<?php echo URL_BASE.'productos/'.strtoupper($producto['serie']); ?>"><?php echo $producto['nombre_producto']; ?></a></h5>
                                    <small><a style="color: grey;" href="<?php echo URL_BASE.strtolower($producto['categoria']); ?>"><?php echo $producto['categoria']; ?></a></small>
                                    <hr style="margin-top: 8px; margin-bottom: 17px;">
                                    <span style="color: red; margin-left: 0px; font-size: 16px;">
                                    	$ <?php echo number_format($producto['precio'],2,',','.'); ?> 
                                    </span> 
                                    <?php if ($producto['descuentoPorProducto'] > 0): ?>               	
                                        <small>
                                            <del> 
                                                $ <?php echo number_format($producto['precioAntesDescuento'],2,',','.'); ?>
                                            </del>
                                        </small>
                                    <?php endif ?>
                                    <i class="fa fa-shopping-bag pull-right" style="font-size: 23px;  color: #888860; position: relative; bottom: 2px; right: 2px; cursor: pointer;" onclick="agergarRapidoBolsa(<?php echo $producto['id_producto']; ?>)"></i> 
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
	   	<?php }

	    static public function imprimirProductoSlider($arrayProductos)
	    { ?>
	    	<div class="container">
                <div class="product-slider">
                    <?php 
                        foreach ($arrayProductos as $producto): 
                        $wl = self::activeWP($producto['id_producto']);
                    ?>
                        <div class="item" style="padding: 0 15px;">
                            <div class="product" style="box-shadow: 0px 1px 7px 1px #939384; border: 0;">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="<?php echo URL_BASE.'productos/'.$producto['serie']; ?>">
                                                <img src="<?php echo URL_BASE.'imgproductos/'.$producto['serie'].'/'.$producto['ruta_img_frontal']; ?>" alt="<?php echo $producto['nombre_producto'] ?>" class="img-responsive" style="">
                                            </a>
                                        </div>
                                       <div class="back">
                                            <a href="<?php echo URL_BASE.'productos/'.$producto['serie']; ?>">
                                                <img src="<?php echo URL_BASE.'imgproductos/'.$producto['serie'].'/'.$producto['ruta_img_reverso']; ?>" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="img/product1.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="caption" style="background-color: #fcfcf4; padding: 6px 18px 0px 18px; height: 115px; border: 0;">
                                		<a style="cursor: pointer;">
                                            <i class="fa <?php echo $wl['classH']; ?> pull-right j-wishlist" onclick="<?php echo $wl['function']; ?>" style="margin: 12px 6px; color: grey;">
                                            </i>
                                        </a> 
                                    <h5 style="margin-bottom: 2px; margin-top: 4px;"><a style=" color: black;" href="<?php echo URL_BASE.'productos/'.strtoupper($producto['serie']); ?>"><?php echo $producto['nombre_producto']; ?></a></h5>
                                    <small><a style="color: grey;" href="<?php echo URL_BASE.strtolower($producto['categoria']); ?>"><?php echo $producto['categoria']; ?></a></small>
                                    <hr style="margin-top: 8px; margin-bottom: 10px;">
                                    <i class="fa fa-shopping-bag pull-right" style="font-size: 23px; color: #888860; position: relative; bottom: -4px; right: 4px; cursor: pointer;" onclick="agergarRapidoBolsa(<?php echo $producto['id_producto']; ?>)"></i> 
                                    <span>
                                        <span style="color: red; margin-left: 0px; font-size: 16px; line-height: 30%; position: relative; top: 8px;">
                                            $ <?php echo number_format($producto['precio'],2,',','.'); ?> 
                                        </span> 
                                        <br>
                                        <?php if ($producto['descuentoPorProducto'] > 0): ?>               	
	                                        <small>
	                                            <del> 
	                                                $ <?php echo number_format($producto['precioAntesDescuento'],2,',','.'); ?>
	                                            </del>
	                                        </small>
                                        <?php endif ?>

                                    </span>
                                    
                                   
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>
                    <?php endforeach ?>
                </div>
            </div>    
	  <?php  }
	}

 ?> 