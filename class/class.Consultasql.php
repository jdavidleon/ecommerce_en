<?php 
	/**
	* Consulta BD
	*/
	class Consultasql{

		public static function descuentos($producto,$precioBase){
		  	/*Buscar Descuentos*/
            $sql_buscar_descuentos = "SELECT *, (p.precio - ((p.precio*pd.porcentaje)/100)) as valorConDescuento
                                            FROM productos_descuento as pd
                                            INNER JOIN productos as p on p.id_producto = pd.id_producto
                                            WHERE pd.id_producto= ? 
                                            AND pd.fecha_inicial < ? 
                                            AND pd.fecha_limite > ?";
            $params = array("iss", Sqlconsult::escape($producto),date("Y-m-d H:m:s"),date("Y-m-d H:m:s"));
            $buscar_descuentos = Sqlconsult::consultaBd($sql_buscar_descuentos,$params);

           
            if ($buscar_descuentos[1]->num_rows == 1) {
                $descuentosP = $buscar_descuentos[1]->fetch_array(MYSQLI_ASSOC);
                $precioProducto = $descuentosP['valorConDescuento'];
                $porcentajeDescuento = $descuentosP['porcentaje'];                        
            }else{                                   
                $precioProducto = $precioBase;
                $porcentajeDescuento = 0;
                $descuentosP = array();
            }

            return array($buscar_descuentos,$porcentajeDescuento,$precioProducto,$descuentosP);
		}
	}
?>