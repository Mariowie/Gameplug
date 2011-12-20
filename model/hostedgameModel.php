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
            
        }
        
        /**
         * Deletes a HostedGame from the database
         * @param int $id 
         * @return void
         */
         function deleteHostedGame($id)
        {
            
        }
        
        /**
         * returns hosted games as filterd by the parameters
         * @param int $id
         * @param int $gameId
         * @param int $userId
         * 
         * @return  array(hostedGame(id,game.name,user.name,waitingForPlayers,amountOfPlayer,message,ipaddress))
         */        
         function selectHostedGame($gameId,$userId,$id)
        {
            
        }
        
    class Hostedgame_Model extends Database
    { 

    }    
?>    