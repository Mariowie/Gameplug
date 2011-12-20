<?php

require_once("nuSOAP/lib/nusoap.php");
include('/model/achievementModel.php');
include('database.php');
$namespace = "http://localhost/gameplug/webservice.php";
// create a new soap server
$server = new soap_server();
// configure our WSDL
$server->configureWSDL("GamePlug");
// set our namespace
$server->wsdl->schemaTargetNamespace = $namespace;
// tell nusoap about the complex data type
$server->wsdl->addComplexType('Achievement','complexType','struct','all','',
		array(
			'id' => array('name' => 'id','type' => 'xsd:int'),
			'gameName' => array('name' => 'phonenumber','type' => 'xsd:string'),
			'titel' => array('name' => 'titel','type' => 'xsd:string'),
			'description' => array('name' => 'description','type' => 'xsd:string'),
			'points' => array('name' => 'points','type' => 'xsd:int'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Achievements','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Achievement[]')),'tns:Achievement');

$server->wsdl->addComplexType('Game','complexType','struct','all','',
		array(
			'id' => array('name' => 'id','type' => 'xsd:int'),
			'name' => array('name' => 'name','type' => 'xsd:string'),
			'developer' => array('name' => 'developer','type' => 'xsd:string'),
			'downloadUrl' => array('name' => 'downloadUrl','type' => 'xsd:string'),
			'releaseDate' => array('name' => 'releaseDate','type' => 'xsd:int'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Games','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Game[]')),'tns:Game');

$server->wsdl->addComplexType('Highscore','complexType','struct','all','',
		array(
			'gameName' => array('name' => 'gameName','type' => 'xsd:string'),
			'userName' => array('name' => 'userName','type' => 'xsd:string'),
			'score' => array('name' => 'score','type' => 'xsd:int'),
			'date' => array('name' => 'date','type' => 'xsd:int'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Highscores','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Highscore[]')),'tns:Highscore');

//array(hostedGame(id,game.name,user.name,waitingForPlayers,amountOfPlayer,message,ipaddress))
$server->wsdl->addComplexType('Hostedgame','complexType','struct','all','',
		array(
                        'id'    =>array('name'  =>  'id', 'type'    => 'xsd:string'),
			'gameName' => array('name' => 'gameName','type' => 'xsd:string'),
			'userName' => array('name' => 'userName','type' => 'xsd:string'),
			'waitingForPlayers' => array('name' => 'waitingForPlayers','type' => 'xsd:boolean'),
			'amountOfPlayer' => array('name' => 'amountOfPlayer','type' => 'xsd:int'),
                        'message' => array('name' => 'message','type' => 'xsd:string'),
                        'ipaddress' => array('name' => 'ipaddress','type' => 'xsd:string'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Hostedgames','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Hostedgame[]')),'tns:Hostedgame');

$server->wsdl->addComplexType('User','complexType','struct','all','',
		array(

			'nickname' => array('name' => 'nickname','type' => 'xsd:string'),
			'openId' => array('name' => 'openId','type' => 'xsd:string'),
			'score' => array('name' => 'score','type' => 'xsd:int'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Users','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:User[]')),'tns:User');

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

$server->register(
                // method name:
                'insertAchievementUser', 	
                // parameter list:
                array('userId'=>'xsd:int','achievementId'=>'xsd:int','date'=>'xsd:int'), 
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
                'selectAchievementUser', 	
                // parameter list:
                array('userId'=>'xsd:int','gameId'=>'xsd:int'), 
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
                'insertGame', 	
                // parameter list:
                array('id'=>'xsd:int','name'=>'xsd:string','releaseDate'=>'xsd:int','developer'=>'xsd:string','downloadUrl'=>'xsd:string'), 
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
                'updateGame', 	
                // parameter list:
                array('id'=>'xsd:int','name'=>'xsd:string','releaseDate'=>'xsd:int','developer'=>'xsd:string','downloadUrl'=>'xsd:string'), 
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
                'selectGame', 	
                // parameter list:
                array('id'=>'xsd:int','name'=>'xsd:string','developer'=>'xsd:string'), 
                // return value(s):
                array('return'=>'tns:Games'),
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
                'deleteGame', 	
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

$server->register(
                // method name:
                'insertHighscore', 	
                // parameter list:
                array('gameId'=>'xsd:int','userId'=>'xsd:int','score'=>'xsd:int','date'=>'xsd:int'), 
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
                'selectHighscore', 	
                // parameter list:
                array('gameId'=>'xsd:int','userId'=>'xsd:int','date'=>'xsd:int'), 
                // return value(s):
                array('return'=>'tns:Highscores'),
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
                'deleteHighscore', 	
                // parameter list:
                array('gameId'=>'xsd:int','userId'=>'xsd:int'), 
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
                'insertHostedgame', 	
                // parameter list:
                array('userId'=>'xsd:int','gameId'=>'xsd:int','message'=>'xsd:string','waitingForPlayers'=>'xsd:boolean','amountOfPlayers'=>'xsd:int','ipAddress'=>'xsd:string'), 
                // return value(s):
                array('id'=>'xsd:int'),
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
                'updateHostedgame', 	
                // parameter list:
                array('id'=>'xsd:int','message'=>'xsd:string','waitingForPlayers'=>'xsd:boolean','amountOfPlayers'=>'xsd:int'), 
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
                'deleteHostedgame', 	
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

$server->register(
                // method name:
                'selectHostedgame', 	
                // parameter list:
                array('gameId'=>'xsd:int','userId'=>'xsd:int','id'=>'xsd:int'), 
                // return value(s):
                array('return'=>'tns:Hostedgames'),
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
                'selectUsers', 	
                // parameter list:
                array('openId'=>'xsd:string','id'=>'xsd:int'), 
                // return value(s):
                array('return'=>'tns:Users'),
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
                'insertUser', 	
                // parameter list:
                array('openId'=>'xsd:string','nickname'=>'xsd:string'), 
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
                'updateUser', 	
                // parameter list:
                array('id'=>'xsd:int','nickname'=>'xsd:string','score'=>'xsd:int'), 
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

// Get our posted data if the service is being consumed
// otherwise leave this data blank.                
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) 
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service                    
$server->service($POST_DATA);                
exit();

?>