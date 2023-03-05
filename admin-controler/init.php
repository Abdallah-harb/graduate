<?php
//route for each path
include("connection.php"); //connection with php

$func = "include/function/";
$tpl  = "include/templet/";

//route for each file
include($func."function.php");
include($tpl."header.php");


if(!isset($navbar)){include($tpl."navbar.php");}

?>