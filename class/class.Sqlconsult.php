<?php 

	/**
	* Consultas a la Base de Datos
	* Limpiar datos para solicitudes a la Base de Datos
	*/
	class Sqlconsult{	

		public static function consultaBd($sql_query,$params){
			
			$bd = Database::getInstancia();
			$mysqli = $bd->getConnection();

			$consulta = $mysqli -> prepare($sql_query);
			
			if (count($params) > 0) {				
				$tmp = array();
				foreach ($params as $key => $value) { 
					$tmp[$key] = &$params[$key]; 
				}
				call_user_func_array(array($consulta, 'bind_param'), $tmp);
			}
			
			$consulta->execute();
			$respond = $consulta->get_result();

			if ($consulta->error !== '') {
				echo "<br>";
				echo "<br>";
				echo "Error en consulta sql: <b style='color:red;'>".$consulta->error.'ko</b>';
				echo "<br>";
				echo "<br>";
			}

			return array($consulta,$respond);
			
			$consulta->close();
			$mysqli->close();
		}	

		public static function escape($string){
			
			$bd = Database::getInstancia();
			$mysqli = $bd->getConnection();

			$string = $mysqli->real_escape_string(strip_tags(htmlentities(trim($string))));
			return $string;

			mysqli_close($mysqli);
		}

	}

 ?>