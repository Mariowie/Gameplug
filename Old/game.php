<?php
include('../model/gameModel.php');
  ini_set("soap.wsdl_cache_enabled", 0); 
  ini_set("session.auto_start", 0); 
	
session_start(); 
$server = new SoapServer("../gameplug.wsdl");
$server->setClass('Game_Model');
$server->setPersistence(SOAP_PERSISTENCE_SESSION); 
$server->handle();
?>
