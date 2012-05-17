<?php

    /**
     * @author Mario Herbers
     */
    
            /**
         * Inserts a hostedgame into the database
         * @param int $userId
         * @param int $gameId
         * @param String $message
         * @param Boolean $waitingForPlayers
         * @param int $amountOfPlayers
         * @param string $ipAddress 
         * @return id
         */
         function insertHostedGame($userId, $gameName, $message,$waitingForPlayers,
 					$amountOfPlayers,$maxplayers,$ipAddress,$developer)
        {
             $gameId = selectGames(-1,$gameName,$developer,-1);
           $gameId = $gameId[0]['id'];
             $database = new Database();
            $sql = "INSERT INTO `hostedgames` (`userid`,`gameid`,`message`,`waitingForPlayers`,
            			`amountOfPlayers`,`maxplayers`,`ip-address`) 
                    VALUES('%s','%s','%s','%s','%s','%s','%s')";
            return $database->query($sql,array($userId, $gameId, $message,$waitingForPlayers,
            				$amountOfPlayers,$maxplayers,$ipAddress),true);
        }
        
        /**
         * updates a existing hostedgame
         * @param int $id
         * @param String $message
         * @param Boolean $waitingForPlayers
         * @param int $amountOfPlayers 
         * @return void
         */
         function updateHostedGame($id, $message ,$waitingForPlayers, $amountOfPlayers)
        {
             
            $database = new Database();
            $sql = "UPDATE `hostedgames` 
                    SET `message` = '%s',`waitingForPlayers` = '%s',`amountOfPlayers` ='%s' 
                    WHERE `id` ='%s'";
            $database->query($sql,array($message,$waitingForPlayers,$amountOfPlayers,$id));
            
        }
        
        /**
         * Deletes a HostedGame from the database
         * @param int $id 
         * @return void
         */
         function deleteHostedGame($id)
        {
            $database = new Database();
            $sql = "DELETE FROM `hostedgames` WHERE `id` ='%s'";
            $database->query($sql,array($id));
        }
        
        /**
         * returns hosted games as filterd by the parameters
         * @param int $id
         * @param int $gameId
         * @param int $userId
         * 
         * @return  array(hostedGame(id,game.name,user.name,waitingForPlayers,amountOfPlayer,message,ipaddress))
         */        
         function selectHostedGames($gameName,$developer,$userId,$id)
        {
             
              
            
            $whereArray = array();
            if($userId>0)
            { 
                $whereArray["`users`.`id`"] = $userId;
            }
            if($id >= 0)
            {
                $whereArray["`hostedgames`.`id`"] = $id;
            } 
            if($gameName != "")
            {
                $whereArray["`games`.`name`"] = $gameName;
            }
            if($developer!="")
            {
                $whereArray["`games`.`developer`"] = $developer;
            }
             $database = new Database();
            $sql ="SELECT `hostedgames`.`id`,
	    			`games`.`name` AS 'gameName',
				`games`.`id` AS 'gameid',
				`users`.`nickname` AS 'userName',
				`users`.`id` AS 'userid' ,
				`hostedgames`.`waitingForPlayers`,
				`hostedgames`.`amountOfPlayers`,
				`hostedgames`.`message`,
	                        `hostedgames`.`maxplayers`,
				`hostedgames`.`ip-address` AS 'ipaddress' 
                   FROM `hostedgames` 
                   LEFT JOIN `games` ON `hostedgames`.`gameid` = `games`.`id`
                   LEFT JOIN `users` ON `hostedgames`.`userid` = `users`.`id`";
           
           $sql.=($userId>0 && ($gameName > 0 || $id))?" AND'":'';
           $sql.=($userId>0 )?" `users`.`id` = '%s'":'';
		   $sql.=($developer!="" && ($gameName > 0 || $id) || $userId)?" AND ":"";
           $sql.=($developer!="")?" `games`.`developer` = '%s'":"";
		   
           $param = array();

           return $database->query($sql,$param,false,$whereArray);
        }
        
   
    