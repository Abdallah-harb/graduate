<?php
ob_start();
session_start();
$pageName="Home";
include("init.php");

include($tpl."footer.php");
ob_end_flush();	