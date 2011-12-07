<?php
    include('./database.php');
    
    /**
     * @author Mario Herbers
     */
    class Hostedgame_Model extends Database
    { 
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
        public function insertHostedGame($userId, $gameId, $message,$waitingForPlayers,$amountOfPlayers,$ipAddress)
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
        public function updateHostedGame($id, $message ,$waitingForPlayers, $amountOfPlayers)
        {
            
        }
        
        /**
         * Deletes a HostedGame from the database
         * @param int $id 
         * @return void
         */
        public function deleteHostedGame($id)
        {
            
        }
        
        /**
         * returns hosted games as filterd by the parameters
         * @param int $id
         * @param int $gameId
         * @param int $userId
         * @param boolean $waitingForPlayers 
         * @return array(hostedGame(id,game.name,user.name,waitingForPlayers))
         */        
        public function selectHostedGame($id,$gameId,$userId,$waitingForPlayers)
        {
            
        }
    }    
?>    