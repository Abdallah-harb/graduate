<?php

//Admin functions

/*******************************
********************************
********************************
********************************
********************************
********************************/


//function to write title
function title(){
global $pageName;
	if(isset($pageName)){
		echo $pageName;
	}else{
		echo "Default";
	}
}

//function to redirect to home page or back page
function redirectHome($theMsg,$url= null,$seconds=3){

	if($url === null){

		$url = 'index.php';

	}else{

		$url= isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ? $_SERVER['HTTP_REFERER']: 'index.php';

	}

	echo $theMsg;

	echo "<div class='alert alert-info'> You will be redirect to back page  After $seconds seconds</div>";
	header("refresh:$seconds; url=$url");
	exit();
}

//to chack if(user - category ) it exist on database or not
function checkItem($select,$from,$value){

	global $db;

	$statment = $db->prepare("SELECT $select  FROM $from WHERE  $select = ? ");

	 $statment ->execute(array($value));

	 $count = $statment ->rowCount();

	 return $count;
}
/*function to get all*/
function getAll($field,$table,$where=NULL,$and=NULL,$orderfield,$ordering ="DESC"){
	global $db;
	
	$stmt = $db->prepare("SELECT $field FROM $table $where  ORDER BY $orderfield $ordering ");
	$stmt->execute();
	$all=$stmt->fetchAll();
	return $all;
}

//function to count number of each thing

function countItem( $item, $table ){

	global $db;
		$stmt2 = $db->prepare("SELECT COUNT($item) FROM $table");
		$stmt2 ->execute();
		return  $stmt2->fetchColumn();
}

//function to Get latest record 
//limit number of column to get
function getitem($item,$table,$order,$limit=3){

	global $db;
	$getStmt = $db->prepare("SELECT $item FROM $table ORDER BY $order DESC  LIMIT  $limit ");
	$getStmt ->execute();
	$count = $getStmt->fetchAll();
	return $count;
}