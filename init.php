<?php
//route for each path
include("admin-controler/connection.php"); //connection with php

$func = "Include/functions/";
$tpl  = "Include/templet/";

//route for each file
include($func."function.php");
include($tpl."header.php");


?>