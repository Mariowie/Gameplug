<?php

require_once("nuSOAP/lib/nusoap.php");
include('database.php');
include('model/achievementModel.php');
include('model/gameModel.php');
include('model/highscoreModel.php');
include('model/hostedgameModel.php');
include('model/userModel.php');
  ini_set("soap.wsdl_cache_enabled", 0); 
  ini_set("session.auto_start", 0); 
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
			'gameName' => array('name' => 'gameName','type' => 'xsd:string'),
                        'gameId' => array('name' => 'gameId','type' => 'xsd:int'),
			'title' => array('name' => 'title','type' => 'xsd:string'),
			'description' => array('name' => 'description','type' => 'xsd:string'),
			'points' => array('name' => 'points','type' => 'xsd:int'),
                        'achieved' => array('name' => 'points','type' => 'xsd:int'),
                        'date' => array('name' => 'points','type' => 'xsd:string'),
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
			'releaseDate' => array('name' => 'releaseDate','type' => 'xsd:string'),
                        'highscore' => array('name' => 'highscore','type' => 'xsd:int'),
                        'achievements' => array('name' => 'achievements','type' => 'xsd:int'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Games','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Game[]')),'tns:Game');

$server->wsdl->addComplexType('Highscore','complexType','struct','all','',
		array(
			'gameName' => array('name' => 'gameName','type' => 'xsd:string'),
			'userName' => array('name' => 'userName','type' => 'xsd:string'),
			'gameid' => array('name' => 'gameid','type' => 'xsd:int'),
                        'userid' => array('name' => 'userid','type' => 'xsd:int'),
                        'score' => array('name' => 'score','type' => 'xsd:int'),
			'date' => array('name' => 'date','type' => 'xsd:string'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Highscores','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Highscore[]')),'tns:Highscore');

//array(hostedGame(id,game.name,user.name,waitingForPlayers,amountOfPlayer,message,ipaddress))
$server->wsdl->addComplexType('Hostedgame','complexType','struct','all','',
		array(
                        'id'    =>array('name'  =>  'id', 'type'    => 'xsd:int'),
			'gameName' => array('name' => 'gameName','type' => 'xsd:string'),
			'gameid'    =>array('name'  =>  'gameid', 'type'    => 'xsd:int'),
                        'userName' => array('name' => 'userName','type' => 'xsd:string'),
                        'userid'    =>array('name'  =>  'userid', 'type'    => 'xsd:int'),
			'waitingForPlayers' => array('name' => 'waitingForPlayers','type' => 'xsd:boolean'),
			'amountOfPlayers' => array('name' => 'amountOfPlayers','type' => 'xsd:int'),
                        'message' => array('name' => 'message','type' => 'xsd:string'),
                        'ipaddress' => array('name' => 'ipaddress','type' => 'xsd:string'),
		));
// create an array of that new data type
$server->wsdl->addComplexType('Hostedgames','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Hostedgame[]')),'tns:Hostedgame');

$server->wsdl->addComplexType('User','complexType','struct','all','',
		array(
                        'id'    =>array('name'=>'id','type'=>'xsd:int'),
                        'rank'    =>array('name'  =>  'id', 'type'    => 'xsd:int'),
			'nickname' => array('name' => 'nickname','type' => 'xsd:string'),
			'openId' => array('name' => 'openId','type' => 'xsd:string'),
			'score' => array('name' => 'score','type' => 'xsd:int'),
                        'achievements' =>array('name'=>'achievements','type'=>'xsd:int'),
                        'highscores' =>array('name'=>'highscores','type'=>'xsd:int')
		));
// create an array of that new data type
$server->wsdl->addComplexType('Users','complexType','array','','SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:User[]')),'tns:User');

$server->register(
                // method name:
                'selectAchievements', 	
                // parameter list:
                array('gameId'=>'xsd:int','id'=>'xsd:int','title'=>'xsd:string'), 
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
                array('gameId'=>'xsd:int','title'=>'xsd:string','description'=>'xsd:string','points'=>'xsd:int'), 
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
                array('return'=>'xsd:void'),
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
                array('return'=>'xsd:void'),
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
                array('userId'=>'xsd:int','achievementId'=>'xsd:int','date'=>'xsd:string'), 
                // return value(s):
                array('return'=>'xsd:void'),
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
                'selectAchievementsUser', 	
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
                '<br/>selects the achievements of a user
                 <br/>@param int $userId required
                 <br/>@param int $gameId optional set -1 if not needed
                 <br/>@return void');	

$server->register(
                // method name:
                'insertGame', 	
                // parameter list:
                array('name'=>'xsd:string','releaseDate'=>'xsd:string','developer'=>'xsd:string','downloadUrl'=>'xsd:string'), 
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
                'updateGame', 	
                // parameter list:
                array('id'=>'xsd:int','name'=>'xsd:string','releaseDate'=>'xsd:string','developer'=>'xsd:string','downloadUrl'=>'xsd:string'), 
                // return value(s):
                array('return'=>'xsd:void'),
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
                'selectGames', 	
                // parameter list:
                array('id'=>'xsd:int','name'=>'xsd:string','developer'=>'xsd:string','user'=>'xsd:int'), 
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
                array('return'=>'xsd:void'),
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
                array('gameId'=>'xsd:int','userId'=>'xsd:int','score'=>'xsd:int','date'=>'xsd:string'), 
                // return value(s):
                array('return'=>'xsd:void'),
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
                'selectHighscores', 	
                // parameter list:
                array('gameId'=>'xsd:int','userId'=>'xsd:int','date'=>'xsd:string'), 
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
                array('return'=>'xsd:void'),
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
                array('return'=>'xsd:void'),
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
                array('return'=>'xsd:void'),
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
                'selectHostedgames', 	
                // parameter list:
                array('gameName'=>'xsd:string','gameAuthor'=>'xsd:string','userId'=>'xsd:int','id'=>'xsd:int'), 
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
                'updateUser', 	
                // parameter list:
                array('id'=>'xsd:int','nickname'=>'xsd:string','score'=>'xsd:int'), 
                // return value(s):
                array('return'=>'xsd:void'),
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