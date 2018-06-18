<?php
class DB{
 	
 	public static function connect(){
 		$pdo = new PDO('mysql:host=sql108.epizy.com;dbname=epiz_22081076_finale;charset=utf8', 'epiz_22081076', 'THEHERO');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 		return $pdo;
 	}

 	public static function query($query, $params = array()){
 		$statement = self::connect()->prepare($query);
 		$statement->execute($params);

 		if(explode(' ', $query)[0] == 'SELECT'){
 			$data = $statement->fetchAll();
 			return $data;
 		}
 	}

}
 ?>
