<?php
$server->register(
                // method name:
                'selectAchievement', 	
                // parameter list:
                array('gameId'=>'xsd:int','id'=>'xsd:int'), 
                // return value(s):
                array('return'=>'tns:Achievements'),
                // namespace:
                $namespace,
                // soapaction: (use default)
                false,
                // style: rpc or document
                'rpc',
                // use: encoded or literal
                'encoded',
                // description: documentation for the method
                'Returns an exhaustive list of all customers in the database');

$server->register(
                // method name:
                'insertAchievement', 	
                // parameter list:
                array('gameId'=>'xsd:int','titel'=>'xsd:string','description'=>'xsd:string','id'=>'xsd:int'), 
                // return value(s):
                array('return'=>'xsd:int'),
                // namespace:
                $namespace,
                // soapaction: (use default)
                false,
                // style: rpc or document
                'rpc',
                // use: encoded or literal
                'encoded',
                // description: documentation for the method
                'Returns an exhaustive list of all customers in the database');				
				
$server->register(
                // method name:
                'updateAchievement', 	
                // parameter list:
                array('id'=>'xsd:int','gameId'=>'xsd:int','titel'=>'xsd:string','description'=>'xsd:string','id'=>'xsd:int'), 
                // return value(s):
                array(),
                // namespace:
                $namespace,
                // soapaction: (use default)
                false,
                // style: rpc or document
                'rpc',
                // use: encoded or literal
                'encoded',
                // description: documentation for the method
                'Returns an exhaustive list of all customers in the database');	
$server->register(
                // method name:
                'deleteAchievement', 	
                // parameter list:
                array('id'=>'xsd:int'), 
                // return value(s):
                array(),
                // namespace:
                $namespace,
                // soapaction: (use default)
                false,
                // style: rpc or document
                'rpc',
                // use: encoded or literal
                'encoded',
                // description: documentation for the method
                'Returns an exhaustive list of all customers in the database');	
?>

