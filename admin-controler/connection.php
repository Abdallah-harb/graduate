<?php
	
	//connection php with database
$dsn ="mysql:host=localhost:3308;dbname=graduate";//database name
$user = "root";//user name
$pass ="";//pass 

$optioms  =array(
		PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8',
);
try{       //if it corrected it connected

	$db = new PDO($dsn,$user,$pass,$optioms);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	
}
catch(PDOExeption $e){       //else it handel error here.!

		echo "connectiob falled".$e->getMessage();

}
?>