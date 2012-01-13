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
         function insertHostedGame($userId, $gameId, $message,$waitingForPlayers,$amountOfPlayers,$ipAddress)
        {
             $database = new Database();
            $sql = "INSERT INTO `hostedgames` (`userid`,`gameid`,`message`,`waitingForPlayers`,`amountOfPlayers`,`ip-address`) 
                    VALUES('%s','%s','%s','%s','%s','%s')";
            return $database->query($sql,array($userId, $gameId, $message,$waitingForPlayers,$amountOfPlayers,$ipAddress),true);
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
         function selectHostedGames($gameName,$author,$userId,$id)
        {
             $database = new Database();
            $sql ="SELECT `hostedgames`.`id`,`games`.`name` AS 'gameName',
							`games`.`id` AS 'gameid',
							`users`.`nickname` AS 'userName',
							`users`.`id` AS 'userid' ,
							`hostedgames`.`waitingForPlayers`,
							`hostedgames`.`amountOfPlayers`,
							`hostedgames`.`message`,
							`hostedgames`.`ip-address` AS 'ipaddress' 
                   FROM `hostedgames` 
                   LEFT JOIN `games` ON `hostedgames`.`gameid` = `games`.`id`
                   LEFT JOIN `users` ON `hostedgames`.`userid` = `users`.`id`";
           $sql.=($gameName!=""||$userId > 0|| $id >0 || $author !="")?" WHERE":'';
           $sql.=($id>=0)?"`hostedgames`.`id`='%s'":"";
           $sql.=($gameName !="" && ($id >0) )?" AND":"";
           $sql.=($gameName != "")?"`games`.`name` = '%s'":"";
           $sql.=($userId>0 && ($gameName > 0 || $id))?" AND'":'';
           $sql.=($userId>0 )?" `users`.`id` = '%s'":'';
		   $sql.=($author!="" && ($gameName > 0 || $id) || $userId)?" AND ":"";
           $sql.=($author!="")?" `games`.`developer` = '%s'":"";
		   
           $param = array();
           ($id>0)?array_push($param, $id):'';
           ($gameName != "")?array_push($param, $gameName ):'';
           ($userId>0)?array_push($param, $userId):'';
           ($author!="")?array_push($param, $author):'';
           return $database->resultArray($database->query($sql,$param));
        }
        
   
    