<?php 

	/**
	* CRUD - MADEITFORU
	* Developer: JUAN DAVID LEON
	* Developer WebSite: http://www.jdevweb.com 
	*/

	class CRUD extends Sqlconsult
	{
		public static function find($table,$rows='*',$where=null,$params=[],$join=null,$order=null,$limit=null)
		{
			$sql = "SELECT $rows FROM $table ";

			// INNER JOIN - LEFT JOIN - RIGHT JOIN - FULL JOIN
			if ($join != null) {
				$joinResult = self::join($join);
				$sql .= $joinResult;
			}

			// Where conditional
			$sql .= self::makeWhere($where);

			// Order by conditional
			if ($order != null) {
				$sql .= " ORDER BY ".$order;
			}
			
			// limit conditional
			if ($limit != null) {
				$sql .= " LIMIT ".$limit;
			}

			// echo $sql;
			// echo "<br>";
			return parent::consultaBd($sql,$params);
		}
		
		public static function insert($table,$data=[],$unique=null)
		{	
			/*
				$data = [ 'row' => 'dataToInsert'];	
				$unique = ['conditional' =>, 'params' => []]	
			*/
				
			$sql = "INSERT INTO $table ";
			$sql .= "(".implode(', ', array_keys($data)).") VALUES ('".implode("', '", $data). "')";
			// echo $sql;
			// echo "<br>";
			// echo "<br>";
			if ($unique != null) {
				$valUnique = self::unique($table,$unique);
				if ($valUnique > 0) {
					return false;
				}elseif ($valUnique == 0) {
					return parent::consultaBd($sql,[]);					
				}
			}
			// var_dump($sql);
			return parent::consultaBd($sql,[]);
		}

		public static function unique($table,$conditional)
		{	
			$where = $conditional['conditional'];
			$params = $conditional['params'];

			$uniqueData = self::find($table,'*',$where,$params);
			return $uniqueData[1]->num_rows;			
		}

		public static function update($table,$set,$where,$params=[])	
		{	
			/*
				Set = Data to insert = ['key' => 'value']
			*/
			$insert = '';
			$type = '';
			$params2 = [];
			foreach ($set as $key => $value) {
				if ($value === NULL) {
					$insert .= ' '.$key.' = NULL, '; 
				}else{
					$insert .= ' '.$key.' = ?, ';  
				}
				if (Secure::typeChart($value) != false) {
					$type .= Secure::typeChart($value);					
				}
			}
			$data = substr($insert, 0, -2);

			$type .= $params[0]; 

			if ($type != '') {
	    		array_push($params2, $type); 
	    	}

			foreach ($set as $value) {
				if ($value !== NULL) {
					array_push($params2, $value);
				}
			}

			for ($i=1; $i < count($params); $i++) { 
				array_push($params2, $params[$i]);
			}

			$sql = "UPDATE $table SET $data WHERE $where";
			
			return parent::consultaBd($sql,$params2);
		}

		public static function delete($table,$where,$params=[])	
		{
			$sql = "DELETE FROM $table WHERE $where";
			return parent::consultaBd($sql,$params);
		}

		public static function falseDelete($table,$where,$params=[])
		{	
			/*
				// falseDelete() used to save one date of delete form an element without delete it necesarilly update tm_delete from null to CURRENT_TIME
			*/
			return self::update($table,['tm_delete' => date("Y-m-d H:i:s")],$where,$params);
		}

		public static function makeWhere($data = null)
		{	
			if ($data != null) {
				return " WHERE ".$data;
			}
		}

		public static function join($data=[])
		{	
			// Metodo para almacenar condiciones JOIN 0=Method / 1=table / 2=condition
			$queryJoin = '';
			foreach ($data as $query) {
				$queryJoin .= $query[0].' JOIN '. $query[1].' ON '.$query[2].' ';
			}
			return $queryJoin;
		}

		public static function all($table,$rows='*',$where=null,$params=[],$join=null,$order=null,$limit=null)
		{	
			$nuevo = [];
			$consult = self::find($table,$rows,$where,$params,$join,$order,$limit);
			while ($data = $consult[1]->fetch_assoc()) {
				array_push($nuevo,$data);
			}
			return $nuevo;
		}
	
		public static function numRows($table,$rows='*',$where=null,$params=[],$join=null)
		{	
			$consult = self::find($table,$rows,$where,$params,$join);			
			return $consult[1]->num_rows;
		}
	}

